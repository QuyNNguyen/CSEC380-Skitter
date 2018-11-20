from selenium import webdriver
from selenium.webdriver.common.keys import Keys
user = ""
pwd = ""


driver1 = webdriver.Firefox()
driver1.get("localhost")
driver2 = webdriver.Safari()
driver2.get("localhost")
driver3 = webdriver.Chrome()
driver3.get("localhost")