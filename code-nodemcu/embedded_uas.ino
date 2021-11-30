#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <SimpleDHT.h>
//pin sensor pada nodemcu
#define pinDHT 10

//nama wifi + password
const char* ssid = "wifi surga";
const char* password = "rahasiapol";
byte suhu = 0;
byte kelembaban = 0;
//long randNumber;

//deklarasi pin dht
SimpleDHT11 dht11(pinDHT);

//nama website
String serverName = "http://kelompok4t3a.000webhostapp.com/kirimdata.php";

// the following variables are unsigned longs because the time, measured in
// milliseconds, will quickly become a bigger number than can be stored in an int.
unsigned long lastTime = 0;
// Timer set to 10 minutes (600000)
//unsigned long timerDelay = 600000;
// Set timer to 5 seconds (5000)
unsigned long timerDelay = 5000;

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
 
  Serial.println("Timer set to 5 seconds (timerDelay variable), it will take 5 seconds before publishing the first reading.");
}

void loop() {
  // Send an HTTP POST request depending on timerDelay
  if ((millis() - lastTime) > timerDelay) {
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      WiFiClient client;
      HTTPClient http;

      //memanggil fungsi input sensor
      SuhuKelembaban();
      String serverPath = serverName + "?nama=sensor_DHT11&suhu="+suhu+"&lembab="+ kelembaban;
      Serial.print(serverPath);
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverPath.c_str());
      
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        Serial.println(payload);
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
    lastTime = millis();
  }
}

void SuhuKelembaban() {
  suhu = 0;
  kelembaban = 0;
  int err = SimpleDHTErrSuccess;
  if ((err = dht11.read(&suhu, &kelembaban, NULL)) != SimpleDHTErrSuccess){
    Serial.print("Pembacaan sensor DHT gagal!, Error = ");
    Serial.print(err);
    delay(1000);
  }

  Serial.println("Suhu: " + String((int)suhu) + "*C");
  Serial.println("Kelembaban: " + String((int)kelembaban) + "%");
}
