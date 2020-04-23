//pines 
const char sensorGas= A0;
static char gasNatural[22];
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  
}

void loop() {
  // put your main code here, to run repeatedly:
  float gasin=analogRead(sensorGas);//para gas natural de 50 normal a 500 pegado a la hornalla
                                    //para CO de 75 normal a 200 con el fósforo 
  Serial.println(gasin);
  delay(500);
}
