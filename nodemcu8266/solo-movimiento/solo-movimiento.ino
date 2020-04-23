// PINES 
const int movin =13; //pin digital D7 lectura del sensor de movimiento

static char movimiento[22];

void setup() {
  // Iniciando y configurando velocidad del Puerto Serial
  Serial.begin(115200);

  //setup de los pines
  pinMode(movin,INPUT); //pin digital 7 entradada sensor mov 
}

// Esta sección se repetirá continuamente
void loop() {
          //SENSADO DE MOVIMIENTO   
          boolean estadomov = (digitalRead(movin));
          Serial.println(estadomov);
          delay(100);
          if( estadomov ){
            strcpy(movimiento,"Movimiento Detectado");
          }else{
            strcpy(movimiento,"Sin Movimiento");
          }
}
