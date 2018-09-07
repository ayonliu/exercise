from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException, TimeoutException
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from time import sleep
import sys,getopt
import os
import io
import traceback
import logging
import hashlib
import yaml
from pprint import pprint
from datetime import date


def main():
    full_path = ''
    file_dir = 'D:\\demos\\data'
    browser = None
    user = 'xxxxxx'# your account
    passwd = 'xxxxxx'# your password
    try:
        user_agent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36'
        chrome_options = webdriver.ChromeOptions()
        chrome_options.add_argument(f'user-agent={user_agent}')
        '''
        chrome_options.add_argument('--remote-debugging-port=9222')
        chrome_options.add_argument('--headless')
        chrome_options.add_argument('--disable-gpu')
        chrome_options.add_argument('--use-file-for-fake-video-capture')
        chrome_options.add_argument('--use-file-for-fake-audio-capture')
        chrome_options.add_argument('--use-fake-ui-for-media-stream')
        chrome_options.add_argument('--use-fake-device-for-media-stream')
        chrome_options.add_argument('--allow-file-access')
        '''
        prefs = {
            # 'profile.default_content_settings.popups': 0,
            'download.prompt_for_download': False,# 下载不提示，直接保存到指定目录
            'download.default_directory': file_dir
        }
        chrome_options.add_experimental_option('prefs', prefs)
        browser = webdriver.Chrome(chrome_options=chrome_options)
        # browser = webdriver.Firefox()
        # 打开登录页面
        browser.get("https://www.amazon.com/ap/signin?openid.return_to=https%3A%2F%2Faffiliate-program.amazon.com%2Fhome%2Freports&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=amzn_associates_us&openid.mode=checkid_setup&marketPlaceId=ATVPDKIKX0DER&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&openid.pape.max_auth_age=0")
        
        # 设置用户名
        WebDriverWait(browser, 10).until(EC.presence_of_element_located((By.ID, 'ap_email'))).send_keys(user)
        # 设置密码
        # WebDriverWait(browser, 10).until(lambda driver: driver.find_element_by_id('ap_password')).send_keys(passwd)
        WebDriverWait(browser, 10).until(EC.presence_of_element_located((By.ID, 'ap_password'))).send_keys(passwd)
        # 点击登录按钮
        # WebDriverWait(browser, 10).until(lambda driver: driver.find_element_by_id('signInSubmit')).click()
        print('sigin in..')
        WebDriverWait(browser, 10).until(EC.presence_of_element_located((By.ID, 'signInSubmit'))).click()

        # sleep(5)
        print(browser.title)
        print(browser.current_url)
        # raise Exception('spam', 'eggs')
        print('redirect to reports..')
        # browser.get("https://affiliate-program.amazon.co.uk/home/reports")
        browser.get("https://affiliate-program.amazon.com/home/reports")
        sleep(5)
        # exit()
        print('print page title..')
        print(browser.title)
        print(browser.current_url)
        # 点击 Download Reports 按钮
        # WebDriverWait(browser, 10).until(lambda driver: driver.find_element_by_id('ac-report-download-launcher')).click()
        WebDriverWait(browser, 10).until(EC.presence_of_element_located((By.ID, 'ac-report-download-launcher'))).click()

        download_ele = WebDriverWait(browser, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//table[@class='a-dtt-table a-dtt-datatable']/tbody[@class='a-dtt-tbody']/tr[1]/td[4]/a")))
        file_name = download_ele.get_attribute('href').split('&name=')[1]
        full_path = file_dir+'/'+file_name
        # print(file_name,full_path)
        if os.path.exists(full_path):
            os.unlink(full_path)

        # 点击下载
        download_ele.click()
        sleep(5)

    except Exception as ex:
        traceback.print_exc()
        print(type(ex))
    finally:
        print('done.')
        if browser:
            browser.quit()

if __name__ == "__main__":
    main()
    