# Import des prérequis ##########################
from datetime import datetime                   #
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import Select
import time
from selenium.webdriver.common.keys import Keys #
from selenium import webdriver                  #
from selenium.webdriver.common.by import By     #
import mysql.connector                          #
from mysql.connector import errorcode           #
from webdriver_manager.chrome import ChromeDriverManager
#################################################

# Fonctions persos #############################################################
def getNow():                                                                  #
    try:                                                                       #
        return datetime.now().strftime("%d/%m/%Y %H:%M:%S")                    #
    except Exception as ex:                                                    #
        print("/!\\ Erreur, problème de récupération de l'heure actuelle...")  #
        print(ex)                                                              #
                                                                               #
def log(msg):                                                                  #
    try:                                                                       #
        print(getNow(), msg)                                                   #
    except Exception as ex:                                                    #
        print("/!\\ Erreur, problème avec la fonction log()...")               #
        print(ex)                                                              #
                                                                               #
def setValeurInput(cssSel, valeur):                                            #
    try:                                                                       #
        driver.find_element(By.CSS_SELECTOR, cssSel).clear()                   #
        driver.find_element(By.CSS_SELECTOR, cssSel).send_keys(valeur)         #
    except Exception as ex:                                                    #
        log("- Erreur, problème avec la mise à jour de valeur...")             #
        print(ex)                                                              #
################################################################################

# Paramètres ##########################
                                      #
# URL de l'application                #
urlAppli = "http://gsbproject/index.php"   #
                                      #
# Informations de connexion à la BDD  #
configBdd = {                         #
  'user': 'userGsb',                  #
  'password': 'secret',               #
  'host': '127.0.0.1',                #
  'database': 'gsb_frais',            #
  'raise_on_warnings': True           #
}                                     #
                                      #
# Identifiants visiteur               #
login = 'ganne'                       #
mdp = 'vix98'                         #
#######################################

# Création du navigateur
try:
    driver = webdriver.Chrome(ChromeDriverManager().install())
    print(getNow(), "- Ouverture du navigateur : OK")
except Exception as ex:
    print(getNow(), "- Erreur, problème au lancement du navigateur...")
    print(ex)

# Ouverture de la page de connexion
try:
    driver.get(urlAppli)
    log("- Ouverture de la page de connexion : OK")
except Exception as ex:
    log("- Erreur, problème d'accès à la page de connexion...")
    print(ex)

# Connexion du visiteur
try:
    setValeurInput('input[name="login"]', login)
    setValeurInput('input[name="mdp"]', mdp)
    driver.find_element(By.TAG_NAME, 'form').submit()
    log("- Envoi du formulaire de connexion : OK")
except Exception as ex:
    log("- Erreur, la page de connexion est incorrecte...")
    print(ex)

# Connexion à la BDD
try:
    cnx = mysql.connector.connect(**configBdd)
    log("- Connexion à la BDD : OK")
except mysql.connector.Error as err:
  if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
    log("- Erreur, le login ou de mot de passe de la BDD est incorrect...")
  elif err.errno == errorcode.ER_BAD_DB_ERROR:
    log("- Erreur, la BDD n'existe pas...")
  else:
    log("- Erreur : ", err)
except Exception as ex:
    print(ex)

# Création d'un curseur pour récupérer le résultat d'une requête SQL
try:
    cursor = cnx.cursor()
    log("- Création du curseur : OK")
except Exception as ex:
    log("- Erreur, problème à la création du curseur...")
    print(ex)

# Exécution de la requête SQL de récupération du code A2F
try:
    sql = """SELECT utilisateur.codea2f FROM utilisateur WHERE utilisateur.login = %s"""
    cursor.execute(sql, (login,))
    log("- Lancement de la requête SQL de récupération du code A2F : OK")
except Exception as ex:
    log("- Erreur, problème à l'exécution de la requête SQL...")
    print(ex)

# Récupération du code A2F
try:
    code = cursor.fetchone()[0]
    log("- Récupération du code A2F : OK")
except Exception as ex:
    log("- Erreur, problème à la récupération du code A2F...")
    print(ex)

# Saisie du code A2F
try:
    setValeurInput('input[name="code"]', code)
    driver.find_element(By.TAG_NAME, 'form').submit()
    log("- Saisie du code A2F : OK")
except Exception as ex:
    log("- Erreur, la saisie du code A2F est incorrecte...")
    print(ex)

# Est-ce que ça a fonctionné ?
try:
    driver.find_element(By.CLASS_NAME, 'active')
    log("- Connexion à la page d'accueil : OK")
except Exception as ex:
    log("- Erreur, problème à connexion à la page d'accueil...")
    print(ex)

# Selection Visiteur
try:
    driver.get("http://gsbproject/index.php?uc=validationFrais&action=chercheMois")
    driver.find_element_by_id('ok').send_keys(Keys.ENTER)
except Exception as ex:
    log("- Erreur, problème lors de la selection du visiteur")
    print(ex)

# Selection mois
try:
    driver.find_element_by_xpath("/html/body/div/div[3]/form/input").send_keys(Keys.ENTER)
except Exception as ex:
    log("- Erreur, problème lors de la selection du mois")
    print(ex)

#Ajout des éléments
try:
    ETP = driver.find_element_by_name('lesFrais[ETP]').get_attribute('value')
    KM = driver.find_element_by_name('lesFrais[KM]').get_attribute('value')
    NUI = driver.find_element_by_name('lesFrais[NUI]').get_attribute('value')
    REP = driver.find_element_by_name('lesFrais[REP]').get_attribute('value')
    setValeurInput('input[name="lesFrais[ETP]"]', "1")
    setValeurInput('input[name="lesFrais[KM]"]', "1")
    setValeurInput('input[name="lesFrais[NUI]"]', "1")
    setValeurInput('input[name="lesFrais[REP]"]', "1")
    driver.find_element_by_xpath("/html/body/div/div[4]/div/form/input").send_keys(Keys.ENTER)
    time.sleep(2)
    setValeurInput('input[name="lesFrais[ETP]"]', ETP)
    setValeurInput('input[name="lesFrais[KM]"]', KM)
    setValeurInput('input[name="lesFrais[NUI]"]', NUI)
    setValeurInput('input[name="lesFrais[REP]"]', REP)
    driver.find_element_by_xpath("/html/body/div/div[5]/div/form/input").send_keys(Keys.ENTER)
    time.sleep(2)

except Exception as ex:
    log("- Erreur, problème d'ajout de données frais forfaitiser'")
    print(ex)

#Ajout des éléments hors forfait
try:
    date = driver.find_element_by_xpath("/html/body/div/div[6]/div/table/tbody/tr[2]/td[1]/input").get_attribute('value')
    libelle = driver.find_element_by_xpath("/html/body/div/div[6]/div/table/tbody/tr[2]/td[2]/input").get_attribute('value')
    montant = driver.find_element_by_xpath("/html/body/div/div[6]/div/table/tbody/tr[2]/td[3]/input").get_attribute('value')
    setValeurInput('input[name="date"]', "15/12/2021")
    setValeurInput('input[name="libelle"]', "Test du libelle")
    setValeurInput('input[name="montant"]', "0.26")
    driver.find_element_by_xpath("/html/body/div/div[6]/div/table/tbody/tr[2]/td[4]/input").send_keys(Keys.ENTER)
    time.sleep(2)
    setValeurInput('input[name="date"]', date)
    setValeurInput('input[name="libelle"]', libelle)
    setValeurInput('input[name="montant"]', montant)
    driver.find_element_by_xpath("/html/body/div/div[6]/div/table/tbody/tr[2]/td[4]/input").send_keys(Keys.ENTER)
    time.sleep(2)
except Exception as ex:
    log("- Erreur, problème d'ajout de données frais hors forfait'")
    print(ex)

#Bouton refuser
try:
    driver.find_element_by_xpath("/html/body/div/div[6]/div/table/tbody/tr[2]/td[4]/input[3]").send_keys(Keys.ENTER)
    time.sleep(5)
    driver.find_element_by_xpath("/html/body/div/div[5]/div/table/tbody/tr[2]/td[4]/input[3]").send_keys(Keys.ENTER)
    time.sleep(5)

except Exception as ex:
    log("- Erreur, problème du bouton refuser'")
    print(ex)

# Fermeture de la fenetre
try:
    driver. close()
    print("Fenêtre fermé")
except Exception as ex:
    log("- Erreur lors de la fermeture de la fenetre'")
    print(ex)

