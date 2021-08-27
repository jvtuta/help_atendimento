Projeto destinado a melhoria no processo de atribuição de metas e gerenciamento de atendentes.

Projeto contem algumas features como chat, importação de planilhas, edição das planilhas direto no front end e gerenciamento de metas. 

1° Instalação automatizada do pacote /teddysun/lamp (opcional caso ja possua o srv configurado)
2° Remover o proc do php.ini, após a remoção reiniciar o serviço apache
3° Instalação das dependencias
4° Necessário configurar o arquivo de de ui/authenticates, trocando email para nome_usuario
5° Arquivo .env configs:
    *BROADCAST_DRIVER=pusher
    *JWT_TTL=120
    *JWT_SECRET
    *PUSHER_APP_ID=myappid
    *PUSHER_APP_KEY=myappkey
    *PUSHER_APP_SECRET=myappsocket
    *PUSHER_APP_CLUSTER=mt1
    *APP_DEBUG=false
6° Criar link do storage/public para public
7° Trocar link do default(previamente instalado) para o helpatendimento/public
8° Permissões de arquivos e pastas 
    *chmod 755 * -R
    *chown apache:apache -R *
    *find * -type d -exec chmod 755 {}\;
    *find * -type f -exec chmod 644 {}\;
    
Pronto! Seu sistema helpatendimento está configurado!
