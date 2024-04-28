import cv2 as cv
import requests
import PySimpleGUI as sg
import time
from tempfile import gettempdir


valor=True
url = "http://server_url/api/sensor"
url_photos="http://server_url/api/picture"
url_estado="http://server_url/api/trigger"

def main():
    layout = [[sg.Button("Tirar Fotos", key="post"),sg.Button("EsperarDados", key="get")],
    [sg.Button("Sair", button_color=('white', 'darkred'), key="Exit")]]

    layout = [[sg.VPush()],
              [sg.Push(), sg.Column(layout,element_justification='c'), sg.Push()],
              [sg.VPush()]]

    window = sg.Window('Camera', layout, size=(350,150))

    while True:
        event , values= window.read()
        if event == sg.WIN_CLOSED or event == 'Exit':
            break
        if event == 'post':
            window.Hide()

            try:
                while True:
                    r=requests.get(url+'?imagens_armazem')
                    if r.status_code == 200:
                        cont = r.text.replace("|", "")
                        cont=int(cont)+1
                        camera = cv.VideoCapture(0)
                        ret, image = camera.read()
                        cv.imwrite(gettempdir()+'/armazem'+str(cont)+'.jpg', image)
                        camera.release()
                        cv.destroyAllWindows()

                        files={'imagem':open(gettempdir()+'/armazem'+str(cont)+'.jpg','rb')}
                        r=requests.post(url_photos,files=files)
                        print(r.status_code)
                        cv.waitKey(100)

                    else:
                        sg.popup('Erro no acesso aos dados', title="Erro")

                    
                    time.sleep(3)

            except KeyboardInterrupt:
                sg.popup('Interrompido pelo Utilizador', title="Interrompido")

            window.UnHide()
        if event == 'get':
            window.Hide()

            try:
                while True:
                    r=requests.get(url+'?imagens_armazem')
                    g=requests.get(url_estado)
                    if r.status_code == 200 and g.status_code == 200:
                        cont = r.text.replace("|", "")
                        cont=int(cont)+1
                        verificacao=g.text

                        if verificacao == "1":
                            camera = cv.VideoCapture(0)
                            ret, image = camera.read()
                            cv.imwrite(gettempdir()+'/armazem'+str(cont)+'.jpg', image)
                            camera.release()
                            cv.destroyAllWindows()

                            files={'imagem':open(gettempdir()+'/armazem'+str(cont)+'.jpg','rb')}
                            r=requests.post(url_photos,files=files)
                            g=requests.post(url_estado)
                            print(g.status_code)
                            cv.waitKey(100)
                    else:
                        sg.popup('Erro no acesso aos dados', title="Erro")
                    time.sleep(3)

            except KeyboardInterrupt:
                sg.popup('Interrompido pelo Utilizador', title="Interrompido")

            window.UnHide()

    window.close()

if __name__=='__main__':
    try:
        main()
    except KeyboardInterrupt:
        print("Parado pelo Utilizador")
