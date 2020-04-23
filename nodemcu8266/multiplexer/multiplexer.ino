//MULTIPLEXER 
deco0,1,2 y 3 = 0000 => c0
deco0,1,2 y 3 = 1000 => c1

//PINES DENTRADA AL MULTIPLEXER
const int sigin = 0;//corresponde al pin D3 salida del mx

const int deco0 = 15;//corresponde al pin D8
const int deco1 = 12;//corresponde al pin D6
const int deco2 = 13;//corresponde al pin D7
const int deco3 = 14;//corresponde al pin D5

const int EN = 2;//corresponde al pin D4
 
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);

  pinMode(sigin,INPUT);
  pinMode(deco0,OUTPUT);
  pinMode(deco1,OUTPUT);
  pinMode(deco2,OUTPUT);
  pinMode(deco3,OUTPUT);
  pinMode(EN,OUTPUT);  
}

void loop() {
  // put your main code here, to run repeatedly:
  int sig,bajo=0,alto=1;
//   Serial.println("habilitacion en alto");
//  digitalWrite(EN,HIGH);
//  
//  digitalWrite(deco0,HIGH);
//  digitalWrite(deco1,HIGH);
//  digitalWrite(deco2,HIGH);
//  digitalWrite(deco3,HIGH);
//  delay(100);
//  sig = analogRead(sigin);
//  Serial.print("1111");
//  Serial.println(sig); 
//  digitalWrite(deco0,LOW);
//  digitalWrite(deco1,HIGH);
//  digitalWrite(deco2,HIGH);
//  digitalWrite(deco3,HIGH);
//  delay(100);
//  sig = analogRead(sigin);
//  Serial.print("0111");
//  Serial.println(sig);
//  delay(1000);

  Serial.println("habilitacion en bajo");
   digitalWrite(EN,LOW);
  
  digitalWrite(deco0,LOW);
  digitalWrite(deco1,LOW);
  digitalWrite(deco2,LOW);
  digitalWrite(deco3,LOW);
  delay(50);
  sig = analogRead(sigin);
  Serial.print("0000");
  Serial.println(sig); 
  digitalWrite(deco0,HIGH);
  digitalWrite(deco1,LOW);
  digitalWrite(deco2,LOW);
  digitalWrite(deco3,LOW);
  delay(50);
  sig = analogRead(sigin);
  Serial.print("1000");
  Serial.println(sig);
  delay(1000);
  
}
