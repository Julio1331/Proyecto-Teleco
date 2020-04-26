/*
  pyme escuadron alfa lobo dinamita buena onda

*/

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>


#include "DHT.h"        // para sensor de humedad y temperatura
#define DHTTYPE DHT11   // objeto de tipo DHT11 
// PINES
const int DHTPin = 5;  //Comunicación de datos en el pin 5 (GPIO 5 -- D1)
const int movin = 16; //pin digital D0 lectura del sensor de movimiento
const char analogin = A0; //entrada del mx

//PINES DENTRADA AL MULTIPLEXER
const int sigin = 0;//corresponde al pin D3 salida del mx

const int deco0 = 15;//corresponde al pin D8
const int deco1 = 12;//corresponde al pin D6
const int deco2 = 13;//corresponde al pin D7
const int deco3 = 14;//corresponde al pin D5

//const int SLALT = 4;//corresponde al pin D2

const int EN = 2;//corresponde al pin D4

// Iniciando sensor
DHT dht(DHTPin, DHTTYPE);
// Variables temporales
static char celsiusTemp[7];
static char fahrenheitTemp[7];
static char humidityTemp[7];
static char movimiento[22];
static char gasNatural[5];
static char CO2 [5];


// Replace with your network credentials
const char* ssid     = "Speedy-0EC404";
const char* password = "9376345430";

// REPLACE with your Domain name and URL path or IP address with path
const char* serverName = "http://sensorcasasj.000webhostapp.com/post-esp-data.php";

// Keep this API Key value to be compatible with the PHP code provided in the project page.
// If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key
String apiKeyValue = "tPmAT5Ab3j7F9";


//String sensorName = "dht11";
//String sensorLocation = "casa";


void setup() {
  Serial.begin(115200);

  dht.begin();//humedad y temperatura

  //setup de los pines
  pinMode(movin, INPUT); //pin digital 7 entradada sensor mov
  //mx
  pinMode(sigin, INPUT);
  pinMode(deco0, OUTPUT);
  pinMode(deco1, OUTPUT);
  pinMode(deco2, OUTPUT);
  pinMode(deco3, OUTPUT);
  pinMode(EN, OUTPUT);

  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

}

void loop() {
  //Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    WiFiClient client;

    //SENSADO DE HUMEDAD Y TEMPERATURA
    float h = dht.readHumidity();
    // Leyendo temperatura en Celsius (es la unidad de medición por defecto)
    float t = dht.readTemperature();
    // Leyendo temperatura en Fahrenheit (Si es "true" la leerá en esa unidad)
    float f = dht.readTemperature(true);
    float hic = dht.computeHeatIndex(t, h, false);
    dtostrf(hic, 6, 2, celsiusTemp);
    float hif = dht.computeHeatIndex(f, h);
    dtostrf(hif, 6, 2, fahrenheitTemp);
    dtostrf(h, 6, 2, humidityTemp);


    //SENSADO DE MOVIMIENTO
    int estadomov = (digitalRead(movin));
    Serial.println(estadomov);


    //ENTRADA ANALÓGICA
    digitalWrite(EN, LOW); //habilitacion del multiplexer activo en bajo

    //SENSADO DE GAS NATURAL
    //Elijo la entrada del mx C0, correspondiente al sensor MQ4
    digitalWrite(deco0, LOW);
    digitalWrite(deco1, LOW);
    digitalWrite(deco2, LOW);
    digitalWrite(deco3, LOW);
    delay(50);// espero a que la salida sea estable
    int sensorGas = analogRead(analogin);
    delay(50);// espero lectura sea confiable
    //paso el dato leido tipo entero a char para poder mostrarlo en la página
    String aux;
    aux = String(sensorGas);//primero a string
    aux.toCharArray(gasNatural, 5); //luego a cadena de caracteres

    //SENSADO DE CO2
    //Elijo la entrada del mx C1, correspondiente al sensor MQ7
    digitalWrite(deco0, HIGH);
    digitalWrite(deco1, LOW);
    digitalWrite(deco2, LOW);
    digitalWrite(deco3, LOW);
    delay(50);// espero a que la salida sea estable
    int sensorCO2 = analogRead(analogin);
    delay(50);// espero lectura sea confiable
    //paso el dato leido tipo entero a char para poder mostrarlo en la página
    aux = String(sensorCO2);//primero a string
    aux.toCharArray(CO2, 5); //luego a cadena de caracteres

    // Prepare your HTTP POST request data

    String httpRequestData = "api_key=" + apiKeyValue + "&temp=" + celsiusTemp + "&hum=" + humidityTemp + "&mov=" + estadomov + "&gas=" + gasNatural + "&aire=" + CO2 + "";


    // String httpRequestData = "api_key=" + apiKeyValue + "&sensor=" + sensorName + "&location=" + sensorLocation + "&value1=" + celsiusTemp + "&value2=" + fahrenheitTemp + "&value3=" + humidityTemp + "";

    if (http.begin(serverName)) {
      Serial.println("conecto");
    } else {
      Serial.println("error");
    }
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpResponseCode = http.POST(httpRequestData);
    Serial.println(httpResponseCode);


    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);


    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 30 seconds
  delay(10000);
}
