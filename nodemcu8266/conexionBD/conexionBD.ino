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
static float celsiusTemp;
static float fahrenheitTemp;
static float humidityTemp;
static float movimiento;
static float gasNatural;
static float CO2;


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
    celsiusTemp = dht.readTemperature();
    // Leyendo temperatura en Fahrenheit (Si es "true" la leerá en esa unidad)
    float f = dht.readTemperature(true);
    //float hic = dht.computeHeatIndex(t, h, false);
    //dtostrf(hic, 6, 2, celsiusTemp);
    humidityTemp = dht.computeHeatIndex(f, h);
//    dtostrf(hif, 6, 2, fahrenheitTemp);
//    dtostrf(h, 6, 2, humidityTemp);


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
    int gascad = analogRead(analogin);
    float gasten=(gascad*3.3)/1024;
    gasNatural = 661.4*(gasten*gasten*gasten)-2514.4*(gasten*gasten)+2669.3*gasten-12.7;//ecuación para sensor de gas natural
    delay(50);// espero lectura sea confiable
    //  SENSOR DE GAS BUTANO AJUSTE DE VALORES ---> ("JDG")/*************/
    //int gasBcad = analogRead(analogin);
    //float gasBten = (gasBten*3.3)/1024;
    //gasNatural = 196*(gasBten*gasBten*gasBten*gasBten*gasBten*gasBten)-2875*(gasBten*gasBten*gasBten*gasBten*gasBten)+16599*(gasBten*gasBten*gasBten*gasBten)-46834*(gasBten*gasBten*gasBten)+64631*(gasBte*gasBten)-34735*(gasBten);
    //delay(50);
    /**********************/
    
    //SENSADO DE CO2
    //Elijo la entrada del mx C1, correspondiente al sensor MQ7
    digitalWrite(deco0, HIGH);
    digitalWrite(deco1, LOW);
    digitalWrite(deco2, LOW);
    digitalWrite(deco3, LOW);
    delay(50);// espero a que la salida sea estable
    int co2cad = analogRead(analogin);
    float co2ten = (co2cad*3.3)/1024;
    CO2 = 33*(co2ten*co2ten*co2ten*co2ten*co2ten)-437.8*(co2ten*co2ten*co2ten*co2ten)+2156.5*(co2ten*co2ten*co2ten)-4657.2*(co2ten*co2ten)+3735.5*co2ten;
    delay(50);// espero lectura sea confiable
    //SENSOR DE CALIDAD DE AIRE -->> ("JDG")
//    int co2Bcad = analogRead(analogin);
//    float co2Bten = (co2Bcad*3.3)/1024;
//    CO2 = 81.6*(co2Bten*co2Bten*co2Bten*co2Bten*co2Bten)-619.8*(co2Bten*co2Bten*co2Bten*co2Bten)+1763.9*(co2Bten*co2Bten*co2Bten)-2183.1*(co2Bten*co2Bten)+1051.5*(co2Bten);
//    delay(50);

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
  delay(1800000);
 // delay(1000);
}
