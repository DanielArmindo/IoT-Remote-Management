import PySimpleGUI as sg
from cv2 import split
import requests
from time import strftime
import fileinput

sg.theme('DefaultNoMoreNagging')

url = "http://server_url/api/sensor"
url_post = "http://server_url/api/sensor/cisco"

#Generic Functions
def datahora():
    return strftime("%Y/%m/%d %H:%M:%S")

#Functions to call api
def get_server(key):
    r=requests.get(url+"?"+key)
    if r.status_code == 200:
        array=(r.text).split('|')
        return array[0],array[1]
    else:
        sg.popup('Erro Ao Aceder ao Servidor', title="Error")
        
def get_server_3(key):
    r=requests.get(url+"?"+key)
    if r.status_code == 200:
        array=(r.text).split('|')
        return array[0],array[1],array[2]
    else:
        sg.popup('Erro Ao Aceder ao Servidor', title="Error")

def validaDados_rececao(temp,luz):
    if int(luz)==1 or int(luz)==2:
        luz="Ligado"
    else:
        luz="Desligado"
    if float(temp)>18:
        Refrecador = "Ligado"
    else:
        Refrecador = "Desligado"
    if float(temp)<15:
        Aquecedor = "Ligado"
    else:
        Aquecedor = "Desligado"

    return luz,Refrecador,Aquecedor

def validaDados_bath(movimento,agua):
    if int(movimento)!=0:
        value1="Detetado"
        value2="Ligado"
    else:
        value1="Não Detetado"
        value2="Desligado"
    if int(agua)>2:
        value3="Ligado"
    else:
        value3="Desligado"

    return value1,value2,value3

def validaDados_portoes_disclaimer(descargas,principal,disclaimer):
    if int(descargas)!=0:
        estado1="Aberta"
    else:
        estado1="Fechada"

    if int(principal)!=0:
        estado2="Aberta"
    else:
        estado2="Fechada"
    
    linhas =disclaimer.split('\\n')
    if linhas[0]=="":
        linhas[0]="(sem letras)"
    if linhas[1]=="":
        linhas[1]="(sem letras)"
    
    return estado1,estado2,linhas

def post_server_luz(dados):
    r=requests.post(url_post+'?luz_rececao_py',data=dados)
    if r.status_code == 200:
        sg.popup('Submissão de dados Aceite', title="Sucesso")
    else:
        sg.popup('Erro Inesperado Na Submissão dos Dados', title="Erro")

def post_server_porta(dados):
    r=requests.post(url_post+'?atuar_porta_py',data=dados)
    if r.status_code == 200:
        sg.popup('Submissão de dados Aceite', title="Sucesso")
    else:
        sg.popup('Erro Inesperado Na Submissão dos Dados', title="Erro")

def post_server_disclaimer(dados):
    r=requests.post(url_post+'?atuar_disclaimer_py',data=dados)
    if r.status_code == 200:
        sg.popup('Submissão de dados Aceite', title="Sucesso")
    else:
        sg.popup('Erro Inesperado Na Submissão dos Dados', title="Erro")

#Page Reception
def rececao():
    temp,luz=get_server("rececao")
    luz,refresca,aquece=validaDados_rececao(temp,luz)

    layout = [[sg.Text("Temperatura - "+temp+"ºC",key="temp")],
    [sg.Text("Led - "+luz,key="led")], 
    [sg.Text("Refrecador - "+refresca,key="arref")],
    [sg.Text("Aquecedor - "+aquece,key="aquec")],
    [sg.Button("Refresh Dados", key="refresh"),sg.Button("Ligar/Desligar Luz", key="ligar_led"),sg.Button("Voltar", button_color=('white', 'darkred'), key="Exit")],
    [sg.Text("Nota: Os valores apresentados são estáticos para ver \nultimas informações é necessário dar refresh no botão")]]

    layout = [[sg.VPush()],
              [sg.Push(), sg.Column(layout,element_justification='c'), sg.Push()],
              [sg.VPush()]]

    window = sg.Window("Receção", layout, size=(400,230))
    while True:
        event, values = window.read()
        if event == sg.WIN_CLOSED or event == 'Exit':
            break
        if event == 'ligar_led':
            window.Hide()

            try:
                layout2 = [[sg.Text('Desligar a luz da receção -> digite "0" ou "desligar luz"')],
                [sg.Text('Ligar a luz fraco -> digite "1" ou "ambiente"')],
                [sg.Text('Ligar a luz maximo -> digite "2" ou "maximo"')],
                [sg.InputText(key="texto")],[sg.OK(key="submete"), sg.Cancel()]]
                layout2 = [[sg.VPush()],
                [sg.Push(), sg.Column(layout2,element_justification='c'), sg.Push()],
                [sg.VPush()]]
                window2 = sg.Window('Liga / Desliga Luz Da Receção', layout2)
                while True:             
                    event, values = window2.read()
                    if event == 'submete':
                        value=values['texto']
                        if value == "0" or value == "desligar luz":
                            valores={'nome': 'luz_rececao' , 'valor': 0, 'data_hora': datahora()}
                            post_server_luz(valores)
                            break
                        elif value == "1" or value == "ambiente":
                            valores={'nome': 'luz_rececao' , 'valor': 1, 'data_hora': datahora()}
                            post_server_luz(valores)
                            break
                        elif value == "2" or value == "maximo":
                            valores={'nome': 'luz_rececao' , 'valor': 2, 'data_hora': datahora()}
                            post_server_luz(valores)
                            break
                        else:
                            sg.popup('Erro Inesperado', title="Erro")
                    if event in (sg.WIN_CLOSED, 'Cancel'):
                        break

                window2.close()

            except KeyboardInterrupt:
                sg.popup('Evento terminado pelo utilizador', title="Finalização")
            except:
                sg.popup('Erro Inesperado', title="Error")

            window.UnHide()
        if event == 'refresh':
            temp,luz=get_server("rececao")
            luz,refresca,aquece=validaDados_rececao(temp,luz)

            window['temp'].update('Temperatura - '+temp+'ºC')
            window['led'].update('Led - '+luz)
            window['arref'].update('Refrecador - '+refresca)
            window['aquec'].update('Aquecedor - '+aquece)
    window.close()

#Page Bathroom
def casa_banho():
    sen_movimento,niv_agua=get_server("casa_banho")
    movimento,led,sprinkler=validaDados_bath(sen_movimento,niv_agua)

    layout = [[sg.Text("Movimento - "+movimento,key="movimento")],
    [sg.Text("Led - "+led,key="led")], 
    [sg.Text("Nivel Agua - "+niv_agua+"m",key="niv_agua")],
    [sg.Text("Splinker - "+sprinkler,key="sprinkler")],
    [sg.Button("Refresh Dados", key="refresh"),sg.Button("Voltar", button_color=('white', 'darkred'), key="Exit")],
    [sg.Text("Nota: Os valores apresentados são estáticos para ver \nultimas informações é necessário dar refresh no botão")]]

    layout = [[sg.VPush()],
              [sg.Push(), sg.Column(layout,element_justification='c'), sg.Push()],
              [sg.VPush()]]

    window = sg.Window("Receção", layout, size=(400,230))
    while True:
        event, values = window.read()
        if event == sg.WIN_CLOSED or event == 'Exit':
            break
        if event == 'refresh':
            sen_movimento,niv_agua=get_server("casa_banho")
            movimento,led,sprinkler=validaDados_bath(sen_movimento,niv_agua)

            window['movimento'].update("Movimento - "+movimento)
            window['led'].update("Led - "+led)
            window['niv_agua'].update("Nivel Agua - "+niv_agua+"m")
            window['sprinkler'].update("Splinker - "+sprinkler)

    window.close()

#Function to open/close doors
def atuar_porta(tipo_porta,sensor_name):
    try:
        layout = [[sg.Text('Abrir a porta das '+tipo_porta+' -> digite "1" ou "abrir"')],
        [sg.Text('Fechar a porta das '+tipo_porta+' -> digite "0" ou "fechar"')],
        [sg.InputText(key="texto")],[sg.OK(key="submete"), sg.Cancel()]]

        layout = [[sg.VPush()],
        [sg.Push(), sg.Column(layout,element_justification='c'), sg.Push()],
        [sg.VPush()]]

        window = sg.Window('Abrir / Fechar porta '+tipo_porta, layout)
        while True:             
            event, values = window.read()
            if event == 'submete':
                value=values['texto']
                if value == "0" or value == "fechar":
                    valores={'nome': sensor_name , 'valor': 0, 'data_hora': datahora()}
                    post_server_porta(valores)
                    break
                elif value == "1" or value == "abrir":
                    valores={'nome': sensor_name , 'valor': 1, 'data_hora': datahora()}
                    post_server_porta(valores)
                    break
                else:
                    sg.popup('Erro Inesperado', title="Erro")
            if event in (sg.WIN_CLOSED, 'Cancel'):
                break

        window.close()

    except KeyboardInterrupt:
        sg.popup('Evento terminado pelo utilizador', title="Finalização")
    except:
        sg.popup('Erro Inesperado', title="Error")

def atuar_disclaimer(sensor_name):
    try:
        layout = [[sg.Text('Introduza as palavras a aparecer nas linhas(no maximo 14 caracteres)')],
        [sg.InputText(key="texto")],[sg.InputText(key="texto2")],
        [sg.OK(key="submete"), sg.Cancel()]]

        layout = [[sg.VPush()],
        [sg.Push(), sg.Column(layout,element_justification='c'), sg.Push()],
        [sg.VPush()]]

        window = sg.Window('Valor no Disclaimer', layout)
        while True:             
            event, values = window.read()
            if event == 'submete':
                value=values['texto']
                value2=values['texto2']
                if len(value) <= 14 and len(value2) <= 14 and (len(value2) != 0 or len(value) != 0):
                    valores={'nome': sensor_name , 'valor': value+"\\n"+value2, 'data_hora': datahora()}
                    post_server_disclaimer(valores)
                    break
                else:
                    sg.popup('Erro - cada caixa só pode ter até 14 caracteres', title="Erro")

            if event in (sg.WIN_CLOSED, 'Cancel'):
                break

        window.close()

    except KeyboardInterrupt:
        sg.popup('Evento terminado pelo utilizador', title="Finalização")
    except:
        sg.popup('Erro Inesperado', title="Error")

#Doors Page (Warehouse and Discharges)
def portoes_disclaimer_armazem():
    descargas,principal,disclaimer=get_server_3("portoes_disclaimer")
    descargas,principal,disclaimer=validaDados_portoes_disclaimer(descargas,principal,disclaimer)

    layout = [[sg.Text("Porta das Descargas - "+descargas,key="descargas")],
    [sg.Text("Porta Principal/Funcionários - "+principal,key="principal")],
    [sg.Text("1ª linha do disclaimer - "+disclaimer[0],key="disc0"),sg.Text("2ª linha do disclaimer - "+disclaimer[1],key="disc1")],
    [sg.Button("Abrir/Fechar Porta Descargas", key="act_descargas"),sg.Button("Abrir/Fechar Porta Principal", key="act_principal")],
    [sg.Button("Alterar Palavras Disclaimer",key="disclaimer")],
    [sg.Button("Refresh Dados", key="refresh"),sg.Button("Voltar", button_color=('white', 'darkred'), key="Exit")],
    [sg.Text("Nota: Os valores apresentados são estáticos para ver \nultimas informações é necessário dar refresh no botão")]]

    layout = [[sg.VPush()],
              [sg.Push(), sg.Column(layout,element_justification='c'), sg.Push()],
              [sg.VPush()]]

    window = sg.Window("Estado Portas e Disclaimer", layout, size=(500,300))
    while True:
        event, values = window.read()
        if event == sg.WIN_CLOSED or event == 'Exit':
            break
        if event == 'act_descargas':
            window.Hide()
            atuar_porta("descargas","porta_descargas")
            window.UnHide()

        if event == 'act_principal':
            window.Hide()
            atuar_porta("principal","porta_principal")
            window.UnHide()
        
        if event == 'disclaimer':
            window.Hide()
            atuar_disclaimer("disclaimer")
            window.UnHide()

        if event == 'refresh':
            descargas,principal,disclaimer=get_server_3("portoes_disclaimer")
            descargas,principal,disclaimer=validaDados_portoes_disclaimer(descargas,principal,disclaimer)

            window['descargas'].update("Porta das Descargas - "+descargas)
            window['principal'].update("Porta Principal/Funcionários - "+principal)
            window['disc0'].update("1ª linha do disclaimer - "+disclaimer[0])
            window['disc1'].update("2ª linha do disclaimer - "+disclaimer[1])

    window.close()


#Main Page
def main():
    layout = [[sg.Button("Receção", key="rececao"),sg.Button("Casa de Banho", key="casa_banho")],
    [sg.Button("Estado Portões e Disclaimer", key="portoes_disclaimer")],
    [sg.Button("Sair", button_color=('white', 'darkred'), key="Exit")]]

    layout = [[sg.VPush()],
              [sg.Push(), sg.Column(layout,element_justification='c'), sg.Push()],
              [sg.VPush()]]

    window = sg.Window('Armazem', layout, size=(350,150))

    while True:
        event, values = window.read()
        if event == sg.WIN_CLOSED or event == 'Exit':
            break
        if event == 'rececao':
            window.Hide()
            rececao()
            window.UnHide()
        if event == 'casa_banho':
            window.Hide()
            casa_banho()
            window.UnHide()

        if event == 'portoes_disclaimer':
            window.Hide()
            portoes_disclaimer_armazem()
            window.UnHide()

    window.close()

if __name__=='__main__':
    main()
