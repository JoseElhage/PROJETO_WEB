<?php
/*
|--------------------------------------------------------------------------
| Google Maps - API do site CRUD Mundo
|--------------------------------------------------------------------------
| Preencha abaixo com a sua chave de API do Google Maps.
|
| Como obter a chave:
| 1. Acesse https://console.cloud.google.com/
| 2. Crie um projeto (ou use um já existente).
| 3. Em "APIs e serviços" > "Biblioteca", procure por "Maps JavaScript API"
|    e clique em "Ativar".
| 4. Em "APIs e serviços" > "Credenciais", clique em
|    "Criar credenciais" > "Chave de API".
| 5. Cole a chave entre aspas abaixo.
|
| Enquanto a chave estiver vazia, a página do mapa exibe a localização pelo
| modo de incorporação do Google (sem chave), para que o mapa continue
| visível no site.
*/
define('GOOGLE_MAPS_API_KEY', '');

// Localização da sede da ETEC São José dos Campos
// (Etec Profª Ilza Nascimento Pintus - Av. Salmão, 570 - Pq. Res. Aquarius)
define('ETEC_LAT', -23.231251);
define('ETEC_LNG', -45.884399);
define('ETEC_NOME', 'ETEC São José dos Campos - Sede');
define('ETEC_ENDERECO', 'Av. Salmão, 570 - Parque Residencial Aquarius, São José dos Campos - SP, CEP 12246-260');
