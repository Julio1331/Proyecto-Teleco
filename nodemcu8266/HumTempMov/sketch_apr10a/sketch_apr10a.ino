// Incluyendo las librerías del ESP8266 y el DHT
#include <ESP8266WiFi.h> //para transmision wifi
#include "DHT.h"        // para sensor de humedad y temperatura

#define DHTTYPE DHT11   // objeto de tipo DHT11 


// Nombre de la red y su contraseña
const char* ssid = "Speedy-0EC404";
const char* password = "9376345430";

// El Web Server se abrirá en el puerto 80
WiFiServer server(80);

// PINES 
const int DHTPin = 5;  //Comunicación de datos en el pin 5 (GPIO 5 -- D1)
const int movin =16; //pin digital D0 lectura del sensor de movimiento

// Iniciando sensor
DHT dht(DHTPin, DHTTYPE);

// Variables temporales
static char celsiusTemp[7];
static char fahrenheitTemp[7];
static char humidityTemp[7];
static char movimiento[22];


//Esta parte solo se ejecuta al inicio
void setup() {
  // Iniciando y configurando velocidad del Puerto Serial
  Serial.begin(115200);
  delay(10);

  dht.begin();//humedad y temperatura

  //setup de los pines
  pinMode(movin,INPUT); //pin digital 7 entradada sensor mov 
  

  // Conectando a la red WiFi
  Serial.println();
  Serial.print("Conectando a ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi conectado");

  // Starting the web server
  server.begin();
  Serial.println("Web server ejecutándose. Esperando a la ESP IP...");
  delay(10000);

  // Mostrar la dirección ESP IP en el Monitor Serie
  Serial.println(WiFi.localIP());
}

// Esta sección se repetirá continuamente
void loop() {
  // Esperando nuevas conexiones (clientes)
  WiFiClient client = server.available();

  if (client) {
    Serial.println("Nuevo cliente");
    // Boleano para localizar el fin de una solicitud http
    boolean blank_line = true;
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        
        //SENSADO DE HUMEDAD Y TEMPERATURA
        if (c == '\n' && blank_line) {
          float h = dht.readHumidity();
          // Leyendo temperatura en Celsius (es la unidad de medición por defecto)
          float t = dht.readTemperature();
          // Leyendo temperatura en Fahrenheit (Si es "true" la leerá en esa unidad)
          float f = dht.readTemperature(true);
          // Revisión de fallas en la lectura
          if (isnan(h) || isnan(t) || isnan(f)) {
            Serial.println("Fallos al leer el sensor DHT");
            strcpy(celsiusTemp, "Fallido");
            strcpy(fahrenheitTemp, "Fallido");
            strcpy(humidityTemp, "Fallido");
          }
          else {
            // Calculando valores de temperatura en Celsius + Fahrenheit and Humedad
            float hic = dht.computeHeatIndex(t, h, false);
            dtostrf(hic, 6, 2, celsiusTemp);
            float hif = dht.computeHeatIndex(f, h);
            dtostrf(hif, 6, 2, fahrenheitTemp);
            dtostrf(h, 6, 2, humidityTemp);
          }

          //SENSADO DE MOVIMIENTO   
          boolean estadomov = (digitalRead(movin));
          Serial.println(estadomov);
          if( estadomov ){
            strcpy(movimiento,"Movimiento Detectado");
          }else{
            strcpy(movimiento,"Sin Movimiento");
          }
 
          
          //Maquetación de la página con HTML
          client.println("HTTP/1.1 200 OK");
          client.println("Content-Type: text/html");
          client.println("Connection: close");
          client.println();
          // Código para mostrar la temperatura y humedad en la página
          client.println("<!DOCTYPE HTML>");
          client.println("<html>");
          client.println("<head></head><body><h1>HOLA BETY!!!! ;) </h1><h2>SMELPRO - ESP8266 - Humedad y temperatura</h2><h3>Temperatura en Celsius: ");
          client.println(celsiusTemp);
          client.println("*C</h3><h3>Temperatura en Fahrenheit: ");
          client.println(fahrenheitTemp);
          client.println("*F</h3><h3>Humedad: ");
          client.println(humidityTemp);
          client.println("%</h3><h3>");
          
          //Código para mostrar la detección de movimiento 
          client.println("<h3>Estado de Movimiento: ");
          client.println(movimiento);
          client.println("</h3>");
          
          client.println("</body>");
          client.print("<meta http-equiv=\"refresh\" content=\"1\">");  //Actualización de la página cada segundo
          client.println("</html>");        
          break;
        }
        if (c == '\n') {
          // Cuando se empieza a leer una nueva línea
          blank_line = true;
        }else if (c != '\r') {
          // Cuando encuentra un caracter en la línea actual
          blank_line = false;
        }
      }
    }
    // Cerrando la conexión con el cliente
    delay(1);
    client.stop();
    Serial.println("Client disconnected.");
  }
}
