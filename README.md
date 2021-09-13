<h2>Projeto destinado a melhoria no processo de atribuição de metas e gerenciamento de atendentes</h2>

<p>Projeto contem algumas features como chat, importação de planilhas, edição das planilhas direto no front end e gerenciamento de metas. </p>

<p>1° Instalação automatizada do pacote /teddysun/lamp (opcional caso ja possua o srv configurado); </p>
<p>2° Remover o proc do php.ini, após a remoção reiniciar o serviço apache; </p>
<p>3° Instalação das dependencias; </p>
<p>4° Necessário configurar o arquivo de de ui/authenticates, trocando email para nome_usuario; </p>
<p> 5° Arquivo .env configs:
    *BROADCAST_DRIVER=pusher
    *JWT_TTL=120
    *JWT_SECRET
    *PUSHER_APP_ID=myappid
    *PUSHER_APP_KEY=myappkey
    *PUSHER_APP_SECRET=myappsecret
    *PUSHER_APP_CLUSTER=mt1
    *APP_DEBUG=false;
    </p>
<p>6° Criar link do storage/public para public;</p>
<p>7° Trocar link do(/data/www/default, /var/www/index, /var/www/default) default(previamente instalado) para o helpatendimento/public;</p>
<p>8° Permissões de arquivos e pastas ;
    *chmod 755 * -R
    *chown apache:apache -R *
    *find * -type d -exec chmod 755 {}\;
    *find * -type f -exec chmod 644 {}\;</p> 
    
<h4>Pronto! Seu sistema helpatendimento está configurado!</h4>
