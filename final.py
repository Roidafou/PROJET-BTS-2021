# Importations des modules 
import serial
import mysql.connector
import time
import datetime
# Fin des importations des modules 

serialport = "/dev/ttyS0"
baudrate = 9600


# Déclaration des variables 
Temperature = 0
Humi_Air = 0
Humi_Terre = 0
Pression = 0
Luminosite = 0
Anemometre = 0
# Fin déclaration des variables 

ser = serial.Serial(serialport, baudrate)

# Début configuration Xbee
def config():
    nombre = "+++"
    ser.write(nombre.encode('ascii'))
    print(nombre)
    time.sleep(2)

    data = str(ser.readline(3))
    print (data)
    time.sleep(0.1)


    nombre = "ATRE\r" # ATRE :  Revenir à la configuration de base
    ser.write(nombre.encode('ascii'))
    print(nombre)

    nombre = "ATMY0\r" # ATMY : Modifie ou lit les 16 bits de l'adressage source
    ser.write(nombre.encode('ascii'))
    print(nombre)

    nombre = "ATID1111\r" # ATID : Modifie ou lit l'adresse du Pan ID.
    ser.write(nombre.encode('ascii'))
    print(nombre)

    nombre = "ATCN\r" #ATCN : Pour quitter le mode commande. 
    ser.write(nombre.encode('ascii'))
    print(nombre)

    time.sleep(0.1)

    print("Configuration OK")
# Fin configuration Xbee

# Début des fonctions permettant les différentes connexion à la BDD
def cap_Temp():
    mycursor.execute("INSERT INTO cap_Temp (Date_Temperature, Valeur_Temperature) VALUES (%s,%s)", (timestamp,Temperature))
    db.commit()

def cap_Anemo():
    mycursor.execute("INSERT INTO cap_Anemo (Date_Anemometre, Valeur_Anemometre) VALUES (%s,%s)", (timestamp,Anemometre))
    db.commit()

def cap_Humi_Air():
    mycursor.execute("INSERT INTO cap_Humi_Air (Date_Humidite, Valeur_Humidite) VALUES (%s,%s)", (timestamp,Humi_Air))
    db.commit()

def cap_Humi_Terre():
    mycursor.execute("INSERT INTO cap_Humi_Terre (Date_Humidite, Valeur_Humidite) VALUES (%s,%s)", (timestamp,Humi_Terre))
    db.commit()

def cap_Lumi():
    mycursor.execute("INSERT INTO cap_Lumi (Date_Lumiere, Valeur_Lumiere) VALUES (%s,%s)", (timestamp,Luminosite))
    db.commit()

def cap_Pres():
    mycursor.execute("INSERT INTO cap_Pres (Date_Pression, Valeur_Pression) VALUES (%s,%s)", (timestamp,Pression))
    db.commit()

# Fin des fonctions permettant les différentes connexion à la BDD    

config()
db = mysql.connector.connect(host="localhost", user="user", passwd="azerty", database="Projet_1") #Connexion à la bdd
mycursor = db.cursor()
# Fin des fonctions permettant les différentes connexion à la BDD


# Début de la boucle pour ranger les données reçu sur le port série 

while True:

    ts = time.time()
    timestamp = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S') 

	data = str(ser.readline(11)) # Lire les données reçus 
	if data [0:1]=="T": # Si la premiere donnée est un T
		print (data[2:]) # Ecrire les deux dernieres valeurs de la donnée
		Temperature = data[2:] # La variable temperature devient la variable data
		cap_Temp() # Utilisation de la fonction cap_Temp permettant de ranger la donnée dans la bonne table de la BDD

	if data [0:1]=="L":
		print (data[2:])
		Luminosite = data[2:]
		cap_Lumi()

	if data [0:2]=="HS":
		print (data[2:])
		Humi_Terre = data[2:]
		cap_Humi_Terre()

	if data [0:2]=="HA":
		print (data[2:])
		Humi_Air = data [2:]
		cap_Humi_Air()

	if data [0:1]=="P":
		print (data[2:])
		Pression = data[2:]
		cap_Pres()

	if data  [0:1]=="A":
		print (data[2:])
		Anemometre = data [2:]
		cap_Anemo()

# Fin de la boucle pour ranger les données reçu sur le port série 