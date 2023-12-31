#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <WiFi.h>
#include <MQUnifiedsensor.h>
#include <WiFiClientSecure.h>
#include <HTTPClient.h>

#define SCREEN_WIDTH 128 
#define SCREEN_HEIGHT 64
#define FONT_HEIGHT 7
#define OLED_RESET     -1 // Reset pin
#define SCREEN_ADDRESS 0x3C
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

#define         Board                   ("ESP-32") 
#define         Pin                     (34) 
#define         Type                    ("MQ-2") 
#define         Voltage_Resolution      (5) 
#define         ADC_Bit_Resolution      (12) 
#define         RatioMQ2CleanAir        (9.83) 
MQUnifiedsensor MQ2(Board, Voltage_Resolution, ADC_Bit_Resolution, Pin, Type);

#define         Board                   ("ESP-32") 
#define         Pin                     (32) 
#define         Type                    ("MQ-7")
#define         Voltage_Resolution      (5) 
#define         ADC_Bit_Resolution      (12) 
#define         RatioMQ2CleanAir        (27.5) 
MQUnifiedsensor MQ7(Board, Voltage_Resolution, ADC_Bit_Resolution, Pin, Type);

#define         Board                   ("ESP-32") 
#define         Pin                     (33)  
#define         Type                    ("MQ-135")
#define         Voltage_Resolution      (5) 
#define         ADC_Bit_Resolution      (12) 
#define         RatioMQ2CleanAir        (3.6) 
MQUnifiedsensor MQ135(Board, Voltage_Resolution, ADC_Bit_Resolution, Pin, Type);

#define buzzer 16
float thresholdCO = 25;
float thresholdCO2 = 30;
float thresholdLPG = 800;

//CONNECT WIFI
const char* ssid     = "maria";
const char* password = "okegasmaria";

// SERVER DECLARATION
const char* serverName = "https://okegas.000webhostapp.com/post-esp.php";

// API KEY 
String apiKeyValue = "okegasmaria1";

void setup()
{
  Serial.begin(115200); 
  delay(10);

  pinMode(buzzer, OUTPUT);
  
  // WIFI START
  WiFi.begin(ssid, password);
  Serial.println("Connecting");

  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  MQ2.setRegressionMethod(1); 
  MQ2.setA(574.25); MQ2.setB(-2.222); 
  
/*
    Exponential regression:
    Gas    | a      | b
    H2     | 987.99 | -2.162
    LPG    | 574.25 | -2.222
    CO     | 36974  | -3.109
    Alcohol| 3616.1 | -2.675
    Propane| 658.71 | -2.168
  */

  MQ2.init(); 
  Serial.print("Calibrating please wait.");
  float calcMQ2R0 = 0;
  for(int i = 1; i<=10; i ++)
  {
    MQ2.update(); 
    calcMQ2R0 += MQ2.calibrate(RatioMQ2CleanAir);
    Serial.print(".");
  }
  MQ2.setR0(calcMQ2R0/10);
  Serial.println("  done!.");
  
  if(isinf(calcMQ2R0)) {Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected) please check your wiring and supply"); while(1);}
  if(calcMQ2R0 == 0){Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground) please check your wiring and supply"); while(1);}

  MQ2.serialDebug(true);

  MQ7.setRegressionMethod(1); 
  MQ7.setA(99.042); MQ7.setB(-1.518); 
  
/*
    Exponential regression:
  GAS     | a      | b
  H2      | 69.014  | -1.374
  LPG     | 700000000 | -7.703
  CH4     | 60000000000000 | -10.54
  CO      | 99.042 | -1.518
  Alcohol | 40000000000000000 | -12.35
  */

  MQ7.init(); 
 
  Serial.print("Calibrating please wait.");
  float calcMQ7R0 = 0;
  for(int i = 1; i<=10; i ++)
  {
    MQ7.update(); 
    calcMQ7R0 += MQ7.calibrate(RatioMQ2CleanAir);
    Serial.print(".");
  }
  MQ7.setR0(calcMQ7R0/10);
  Serial.println("  done!.");
  
  if(isinf(calcMQ7R0)) {Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected) please check your wiring and supply"); while(1);}
  if(calcMQ7R0 == 0){Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground) please check your wiring and supply"); while(1);}
  
  MQ7.serialDebug(true); 

  MQ135.setRegressionMethod(1); 
  MQ135.setA(110.47); MQ135.setB(-2.862); 
  
/*
    Exponential regression:
  GAS      | a      | b
  CO       | 605.18 | -3.937  
  Alcohol  | 77.255 | -3.18 
  CO2      | 110.47 | -2.862
  Toluen  | 44.947 | -3.445
  NH4      | 102.2  | -2.473
  Aceton  | 34.668 | -3.369
  */

  MQ135.init(); 
 
  Serial.print("Calibrating please wait.");
  float calcMQ135R0 = 0;
  for(int i = 1; i<=10; i ++)
  {
    MQ135.update(); 
    calcMQ135R0 += MQ135.calibrate(RatioMQ2CleanAir);
    Serial.print(".");
  }
  MQ135.setR0(calcMQ135R0/10);
  Serial.println("  done!.");
  
  if(isinf(calcMQ135R0)) {Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected) please check your wiring and supply"); while(1);}
  if(calcMQ135R0 == 0){Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground) please check your wiring and supply"); while(1);}
  
  MQ135.serialDebug(true);

    Serial.println();
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);

    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }

    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());

    if(!display.begin(SSD1306_SWITCHCAPVCC, SCREEN_ADDRESS)) {
    Serial.println(F("SSD1306 allocation failed"));
    for(;;); // Don't proceed, loop forever
  }

  // Clear the buffer.
  display.clearDisplay();

  // Display Text
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0,28);
  display.println("Hello");
  display.display();
  delay(2000);
  display.clearDisplay();

  // Display Text
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(3,28);
  display.println("Bonjour");
  display.display();
  delay(2000);
  display.clearDisplay();

  // Display Text
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(3,28);
  display.println("This is OKEGAS");
  display.display();
  delay(5000);
  display.clearDisplay();

  // Display Inverted Text
  display.setTextSize(2);
  display.setTextColor(WHITE); // 'inverted' text
  display.setCursor(3,28);
  display.println("By Group 3");
  display.display();
  delay(4000);
  display.clearDisplay();

  // Scroll part of the screen
  display.setCursor(0,0);
  display.setTextSize(1);
  display.setTextColor(WHITE);  
  display.println("Group 3");
  display.println("Maria");
  display.println("Renny");
  display.println("Sarita");
  display.println("Angga");
  display.println("Dirgam");
  display.display();
  display.startscrollright(0x00, 0x00);
  delay(6000);
  display.clearDisplay();

  // Changing Font Size
  display.setTextColor(WHITE);
  display.setCursor(3,24);
  display.setTextSize(2);
  display.println("Let's Go");
  display.display();
  delay(3000);
  display.clearDisplay();

  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0,0);
  display.println("OKEGAS DATA");
  
  display.print("LPG: ");
  display.print(MQ2.readSensor());
  display.println(" PPM");

  display.print("CO: ");
  display.print(MQ7.readSensor());
  display.println(" PPM");

  display.print("CO2: ");
  display.print(MQ135.readSensor());
  display.println(" PPM");

  display.display();
  delay(6000);
}

void loop()
{
  MQ2.update(); 
  Serial.print(MQ2.readSensor()); 
  Serial.println(" PPM");
  delay(5000); 

  MQ7.update(); 
  Serial.print(MQ7.readSensor()); 
  Serial.println(" PPM");
  delay(5000); 

  MQ135.update(); 
  Serial.print(MQ135.readSensor()); 
  Serial.println(" PPM");
  delay(5000); 

  float lpg = MQ2.readSensor();
  float co = MQ7.readSensor();
  float co2 = MQ135.readSensor();

  if (lpg > thresholdLPG || co > thresholdCO || co2 > thresholdCO2) {
    digitalWrite(buzzer, HIGH);
    delay(1000);
    digitalWrite(buzzer, LOW);
    delay(1000);
  } else {
    delay(2000); // Delay tambahan jika tidak memerlukan bunyi buzzer
  }

  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0,0);
  display.println("OKEGAS DATA");
  
  display.print("LPG: ");
  display.print(MQ2.readSensor());
  display.println(" PPM");

  display.print("CO: ");
  display.print(MQ7.readSensor());
  display.println(" PPM");

  display.print("CO2: ");
  display.print(MQ135.readSensor());
  display.println(" PPM");

  display.display();
  delay(6000);

  //CHECK WIFI CONNECTION
  //CHECK WIFI CONNECTION
  if(WiFi.status() == WL_CONNECTED) {
    WiFiClientSecure *client = new WiFiClientSecure;
    client->setInsecure(); // don't use SSL certificate
    HTTPClient https;

    // DOMAIN CONNECT
    https.begin(*client, serverName);

    // Specify content-type header
    https.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare your HTTP POST request data
    String httpRequestData = "api_key=" + apiKeyValue + "&lpg=" + MQ2.readSensor() + "&co=" + MQ7.readSensor() + "&co2=" + MQ135.readSensor();

    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);

    // Send HTTP POST request
    int httpResponseCode = https.POST(httpRequestData);

    // Check for a successful response
    if (httpResponseCode > 0) {
      String response = https.getString();
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      Serial.println(response);
    } else {
      Serial.print("HTTP POST request failed, error: ");
      Serial.println(httpResponseCode);
    }

    // End the request
    https.end();
  }

  // Delay before the next loop iteration
  delay(5000);
  }