from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

affUser, affPass = 'xxx', 'xxx'
driver = webdriver.Chrome()
driver.get("https://login.linkshare.com/sso/login?service=http://cli.linksynergy.com/cli/publisher/home.php")
try:
    elementUsername = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "username"))
    )
    elementUsername.send_keys(affUser)
    elementPasswd = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "password"))
    )
    elementPasswd.send_keys(affPass)
    elementLogin = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "login"))
    )
    elementLogin.click()
    print(driver.current_url, driver.title)
finally:
    driver.quit()