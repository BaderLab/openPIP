import sys
import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

def submit_data(database_path):    
    chrome_options = Options()
    chrome_options.add_argument("--disable-search-engine-choice-screen")
    # Initialize the WebDriver
    driver = webdriver.Chrome(options=chrome_options)
    driver.get("https://openpip.baderlab.org/login")
    
    try:
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.ID, 'username'))
            ).send_keys("admin")
        # Wait for the password field to be visible and enter the password
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.ID, 'password'))
            ).send_keys("1234")
        # Wait for the login button to be clickable and click it
        WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, '_submit'))
            ).click()
        print("Login successful")
    except Exception as e:
        print(f"An error occurred: {e}")
        driver.quit()
        return
    
    url = 'https://openpip.baderlab.org/admin/file_manager/FASTA'
    # Open the webpage
    driver.get(url)
    # Wait for the drag-and-drop area to be visible
    wait = WebDriverWait(driver, 10)
    drag_and_drop_area = wait.until(
        EC.visibility_of_element_located((By.CLASS_NAME, 'dz-default.dz-message')))
    # Find the file input element
    file_input = driver.find_element(By.XPATH, '//input[@type="file"]')
    # Simulate dropping the file into the drag-and-drop area
    file_input.send_keys(database_path)
    upload_button = driver.find_element(By.CLASS_NAME, 'dz-button')
    driver.implicitly_wait(10)
    try:
        ActionChains(driver).move_to_element(upload_button).click(upload_button).perform()
    except:
    	pass

    print("File uploaded successfully")
    driver.quit()

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python uploader.py <path_to_tab_separated_file>")
        sys.exit(1)
    
    database_path = sys.argv[1]
    
    if not os.path.isfile(database_path):
        print(f"The file {database_path} does not exist.")
        sys.exit(1)
    
    submit_data(database_path)
