# -*- encoding: utf-8 -*-
import os
from fabric.api import *
from fabric.colors import green, red

env.webapps_root = '/home/localizacion/www/'
env.user_git     = 'andrescefe'

def update(rama):
    with cd(env.repo_root):
        run('git remote set-url origin https://github.com/%s/localizacion.git' % env.user_git)

        if rama != 'master':
            run('git fetch origin %s' % rama)

        run('git checkout %s' % rama)
        run('git pull origin %s' % rama)

def git_revert(commit):
    with cd(env.repo_root):
        run('git remote set-url origin https://github.com/%s/localizacion.git' % env.user_git)
        run('git reset --hard %s' % commit)

def deploy(rama = 'master'):
    print(green("Iniciando el deploy..."))
    # commit_inicial = get_current_commit()
    update(rama)
    # commit_final = get_current_commit()
    # enviar_correo(commit_inicial, commit_final, rama)
    print(green(u"El proceso ha terminado de manera exitosa"))

def pruebas():
    env.project_name = ''
    env.repo_root    = env.webapps_root
    # env.repo_root    = os.path.join(env.webapps_root, env.project_name)
    env.user  = 'localizacion'
    env.hosts = 'ssh-localizacion.alwaysdata.net'
    # env.hosts = ['192.168.1.202','192.168.1.203']
    env.environment = 'Pruebas'

def produccion():
    env.project_name = 'smsnew'
    env.repo_root    = os.path.join(env.webapps_root, env.project_name)
    env.user  = 'webmaster'
    env.hosts = ['192.168.1.241','192.168.1.242']
    env.environment = 'Producción'

def ls():
    with cd(env.repo_root):
        run('pwd')

def revert(commit):
    print(green("Iniciando el rollback..."))
    git_revert(commit)
    print(green(u"El proceso ha terminado de manera exitosa"))

def enviar_correo(commit_inicial, commit_final, rama):
    import smtplib
    import datetime
    from email.MIMEText import MIMEText

    mail_user = 'despliegue@comred.com.co'
    pass_user = 'RzgLiHo3'
    para = [
        'andres.ceferino@comred.com.co',
        'diana.carvajal@comred.com.co'
    ]

    body = """
    Ambiente: %s
    Rama: %s
    Commit anterior: %s
    Commit actual: %s
    Usuario: %s
    Fecha: %s
    Host: %s
    """ % (
        env.environment,
        rama,
        commit_inicial,
        commit_final,
        env.user_git,
        datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
        env.host_string
    )

    msg = MIMEText(body)
    msg['From'] = mail_user
    msg['To'] = ", ".join(para)
    msg['Subject'] = "SMS Interactive: Despliegue"


    smtp = smtplib.SMTP_SSL('smtp.gmail.com', 465)
    smtp.login(mail_user, pass_user)
    text = msg.as_string()
    smtp.sendmail(mail_user, para, text)
    smtp.quit()

def get_current_commit():
    initial_commit = ''
    with cd(env.repo_root):
        output = run("git rev-parse --short HEAD")
        for line in output.splitlines():
            initial_commit += line

    return initial_commit
