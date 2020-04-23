/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

*/

//#ifdef ESP32
//  #include <WiFi.h>
//  #include <HTTPClient.h>
//#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
//#endif

#include "DHT.h"        // para sensor de humedad y temperatura
#define DHTTYPE DHT11   // objeto de tipo DHT11 
// PINES 
const int DHTPin = 5;  //Comunicación de datos en el pin 5 (GPIO 5 -- D1)
// Iniciando sensor
DHT dht(DHTPin, DHTTYPE);
// Variables temporales
static char celsiusTemp[7];
static char fahrenheitTemp[7];
static char humidityTemp[7];
//#include <Wire.h>
//#include <Adafruit_Sensor.h>
//#include <Adafruit_BME280.h>

// Replace with your network credentials
const char* ssid     = "Speedy-0EC404";
const char* password = "9376345430";

// REPLACE with your Domain name and URL path or IP address with path
const char* serverName = "http://sensorcasasj.000webhostapp.com/post-esp-data.php";

// Keep this API Key value to be compatible with the PHP code provided in the project page. 
// If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key 
String apiKeyValue = "tPmAT5Ab3j7F9";


String sensorName = "dht11";
String sensorLocation = "casa";

/*#include <SPI.h>
#define BME_SCK 18
#define BME_MISO 19
#define BME_MOSI 23
#define BME_CS 5*/

//#define SEALEVELPRESSURE_HPA (1013.25)

//Adafruit_BME280 bme;  // I2C
//Adafruit_BME280 bme(BME_CS);  // hardware SPI
//Adafruit_BME280 bme(BME_CS, BME_MOSI, BME_MISO, BME_SCK);  // software SPI

void setup() {
  Serial.begin(115200);
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  // (you can also pass in a Wire library object like &Wire2)
  //bool status = bme.begin(0x76);
//  if (!status) {
//    Serial.println("Could not find a valid BME280 sensor, check wiring or change I2C address!");
//    while (1);
//  }
}

void loop() {
  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
    WiFiClient client;
 
   
    // Your Domain name with URL path or IP address with path
//    if(http.begin(client,serverName)){
//      Serial.println("conecto");
//    }else{
//      Serial.println("error");
//    }
    
    // Specify content-type header
//    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    // lectura sensor
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
    // Prepare your HTTP POST request data
    
//    //Post Data
//  postData = "status=" + ADCData + "&station=" + station ;
//  
//  http.begin("http://192.168.43.128/c4yforum/postdemo.php");              //Specify request destination
//  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
//
//  int httpCode = http.POST(postData);   //Send the request
//  String payload = http.getString();    //Get the response payload
//
//  Serial.println(httpCode);   //Print HTTP return code
//  Serial.println(payload);    //Print request response payload
//
//  http.end();  //Close connection
    
    String httpRequestData = "api_key=" + apiKeyValue + "&sensor=" + sensorName + "&location=" + sensorLocation + "&value1=" + celsiusTemp + "&value2=" + fahrenheitTemp + "&value3=" + humidityTemp + "";

    if(http.begin(serverName)){
      Serial.println("conecto");
    }else{
      Serial.println("error");
    }
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpResponseCode = http.POST(httpRequestData);
    Serial.println(httpResponseCode);
//    String httpRequestData = "api_key=" + apiKeyValue + "&sensor=" + sensorName
//                          + "&location=" + sensorLocation + "&value1=" + String(bme.readTemperature())
//                          + "&value2=" + String(bme.readHumidity()) + "&value3=" + String(bme.readPressure()/100.0F) + "";
    
    
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
    
    // You can comment the httpRequestData variable above
    // then, use the httpRequestData variable below (for testing purposes without the BME280 sensor)
    //String httpRequestData = "api_key=tPmAT5Ab3j7F9&sensor=BME280&location=Office&value1=24.75&value2=49.54&value3=1005.14";

    // Send HTTP POST request
   
     
    // If you need an HTTP request with a content type: text/plain
    //http.addHeader("Content-Type", "text/plain");
    //int httpResponseCode = http.POST("Hello, World!");
    
    // If you need an HTTP request with a content type: application/json, use the following:
    //http.addHeader("Content-Type", "application/json");
    //int httpResponseCode = http.POST("{\"value1\":\"19\",\"value2\":\"67\",\"value3\":\"78\"}");
        
    if (httpResponseCode>0) {
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
  delay(30000);  
}
