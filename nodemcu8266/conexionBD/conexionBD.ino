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

//variables para el acondicionamieto de variables a transmitir 
int contmin = 0, mov = 0;//contmin lleva la cuenta de los minutos
float arrhum[30], promhum, sumhum;
float arrgas[30], promgas, sumgas;
float arrc[30], promc, sumc;
float arrtemp[30], promtemp, sumtemp;


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
const char* ssid     = "SPEEDY-A4B201";
const char* password = "5794157261";

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
 // Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    WiFiClient client;

    

    //************SENSADO Y VERIFICACION DE LECTURAS CONFIABLES**********************//

    //SENSADO DE HUMEDAD Y TEMPERATURA
    //lectura de humedad
    float h = dht.readHumidity();

    if (isnan(h) || h > 90 || h < 20  ) {//verifica que el valor sea un numero y que este dentro del rango de lectura del sensor
      //no se guarda el dato
      Serial.println("lectura de humedad erronea");
    } else {
      //corro los valores en el arreglo
      for (int i = 0; i < 29; i++) { //recorro hasta el último menos uno(actualizo arreglo)
        arrhum[i] = arrhum[i + 1];
      }
      arrhum[29] = h;
    }



    // Leyendo temperatura en Celsius (es la unidad de medición por defecto)
    celsiusTemp = dht.readTemperature();

    if (isnan(celsiusTemp) || celsiusTemp > 50 || celsiusTemp < 0  ) {
      //no se guarda el dato
      Serial.println("lectura de temperatura erronea");
    } else {
      //corro los valores en el arreglo
      for (int i = 0; i < 29; i++) { //recorro hasta el último menos uno
        arrtemp[i] = arrtemp[i + 1];
      }
      arrtemp[29] = celsiusTemp;
    }


    //SENSADO DE MOVIMIENTO
    int estadomov = (digitalRead(movin));

    if (estadomov == 1) {
      mov = 1;
    }


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
    float gasten = (gascad * 3.3) / 1024;
    gasNatural = 661.4 * (gasten * gasten * gasten) - 2514.4 * (gasten * gasten) + 2669.3 * gasten - 12.7; //ecuación para sensor de gas natural
    delay(50);// espero lectura sea confiable
//      SENSOR DE GAS BUTANO AJUSTE DE VALORES mq6 ---> ("JDG")/*************/
//    int gasBcad = analogRead(analogin);
//    float gasBten = (gasBten*3.3)/1024;
//    gasNatural = 45*(gasBten*gasBten*gasBten*gasBten*gasBten*gasBten*gasBten) - 672*(gasBten*gasBten*gasBten*gasBten*gasBten*gasBten) + 3979*(gasBten*gasBten*gasBten*gasBten*gasBten) - 11956*(gasBten*gasBten*gasBten*gasBten) + 19222*(gasBten*gasBten*gasBten) - 15692*(gasBte*gasBten) + 5313 *(gasBten);
//    delay(50);
// if (isnan(gasNatural) || gasNatural < 300 || gasNatural > 10000  ) {
//      //no se guarda el dato
//      Serial.println("error en la lectura de consentracion gas");
//    } else {
//      //corro los valores en el arreglo
//      for (int i = 0; i < 29; i++) { //recorro hasta el último menos uno
//        arrgas[i] = arrgas[i + 1];
//      }
//      arrgas[29] = gasNatural;
//    }
    /**********************/
    if (isnan(gasNatural) || gasNatural < 300 || gasNatural > 10000  ) {
      //no se guarda el dato
      Serial.println("error en la lectura de consentracion gas");
    } else {
      //corro los valores en el arreglo
      for (int i = 0; i < 29; i++) { //recorro hasta el último menos uno
        arrgas[i] = arrgas[i + 1];
      }
      arrgas[29] = gasNatural;
    }


    //SENSADO DE CO2
    //Elijo la entrada del mx C1, correspondiente al sensor MQ7
    digitalWrite(deco0, HIGH);
    digitalWrite(deco1, LOW);
    digitalWrite(deco2, LOW);
    digitalWrite(deco3, LOW);
    delay(50);// espero a que la salida sea estable
    int co2cad = analogRead(analogin);
    float co2ten = (co2cad * 3.3) / 1024;
    CO2 = - 0.7 * (co2ten * co2ten * co2ten * co2ten * co2ten* co2ten * co2ten * co2ten) + 17.9 * (co2ten * co2ten * co2ten * co2ten * co2ten * co2ten * co2ten) - 170.2 * (co2ten * co2ten * co2ten * co2ten * co2ten * co2ten) + 828.7 * (co2ten * co2ten * co2ten * co2ten *co2ten) - 2249.3 * (co2ten * co2ten * co2ten * co2ten) + 3412.5 * (co2ten * co2ten *co2ten) - 2678.1 *(co2ten * co2ten) + 849.3 * co2ten;
    delay(50);// espero lectura sea confiable
//    SENSOR DE CALIDAD DE AIRE mq135 -->> ("JDG")
//        int co2Bcad = analogRead(analogin);
//        float co2Bten = (co2Bcad*3.3)/1024;
//        CO2 = -17.3*(co2Bten*co2Bten*co2Bten*co2Bten*co2Bten*co2Bten*co2Bten)+249.3*(co2Bten*co2Bten*co2Bten*co2Bten*co2Bten*co2Bten)-1338.9*(co2Bten*co2Bten*co2Bten*co2Bten*co2Bten)+3471.7*(co2Bten*co2Bten*co2Bten*co2Bten)-4553.7*(co2Bten*co2Bten*co2Bten)+2826.5*(co2Bten*co2Bten)-562.6*(co2Bten);
//        delay(50);
//    if (isnan(CO2) || CO2 < 10 || CO2 > 1000 ) {
//      //no se guarda el dato
//      Serial.println("error en la lectura de consentracion CO2");
//    } else {
//      //corro los valores en el arreglo
//      for (int i = 0; i < 29; i++) { //recorro hasta el último menos uno
//        arrc[i] = arrc[i + 1];
//      }
//      arrc[29] = CO2;
//    }

    if (isnan(CO2) || CO2 < 10 || CO2 > 500 ) {
      //no se guarda el dato
      Serial.println("error en la lectura de consentracion CO2");
    } else {
      //corro los valores en el arreglo
      for (int i = 0; i < 29; i++) { //recorro hasta el último menos uno
        arrc[i] = arrc[i + 1];
      }
      arrc[29] = CO2;
    }




  //************CALCULO DE PROMEDIOS Y TRANSMICION DE DATOS**********************//
    Serial.print("minuto: ");
    Serial.println(contmin);
    if (contmin == 29) {
      Serial.println("transmision de 30 min");
      //acondicionamiento temperatura
      for (int i = 0; i < 30; i++) {
        sumtemp = sumtemp + arrtemp[i];
      }
      promtemp = sumtemp / 30;
      
      //condicionamiento de humedad
      for (int i = 0; i < 30; i++) {
        sumhum = sumhum + arrhum[i];
      }
      promhum = sumhum / 30;
      
      //acondicionamiento de movimiento
      //solo se transmite la variable mov

      //acondicionamiento de gas
      for (int i = 0; i < 30; i++) {
        sumgas = sumgas + arrgas[i];
      }
      promgas = sumgas / 30;
      
     //acondicionamiento de co2
     for (int i = 0; i < 30; i++) {
        sumc = sumc + arrc[i];
      }
      promc = sumc / 30;
      
      // Prepare your HTTP POST request data

      String httpRequestData = "api_key=" + apiKeyValue + "&temp=" + promtemp + "&hum=" + promhum + "&mov=" + mov + "&gas=" + promgas + "&aire=" + promc + "";


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

      //reinicio de sumadores y variables correspondientes
      contmin = 0;
      sumtemp = 0;
      sumhum = 0;
      mov = 0;
      sumgas = 0;
      sumc = 0;
    }
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 30 seconds
  delay(60000);//espera un minuto
  contmin++;//contador de minutos llega hasta 29
}
