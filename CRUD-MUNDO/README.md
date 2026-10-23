# CRUD Mundo

Sistema web para gerenciamento de informações geográficas (continentes, países, cidades e governantes), com login, controle de permissões por tipo de usuário e registro de logs.

## Sobre o projeto
O CRUD Mundo é uma aplicação web desenvolvida em PHP com banco de dados MySQL, destinada ao cadastro e à consulta de dados geográficos do mundo. O sistema permite organizar continentes, países, cidades e seus respectivos governantes, mantendo os relacionamentos entre eles no banco de dados.

O acesso é protegido por autenticação: cada pessoa entra com um usuário e uma senha, e o que ela pode fazer depende do seu tipo de usuário. Administradores têm controle total sobre os dados, e usuários comuns apenas consultam as informações.

## Funcionalidades

### Gerenciamento de dados
- Cadastro, listagem, edição e exclusão de **continentes**
- Cadastro, listagem, edição e exclusão de **países**, associados a um continente e a um governante
- Cadastro, listagem, edição e exclusão de **cidades**, associadas a um país e a um governante
- Cadastro, listagem, edição e exclusão de **governantes**
- Busca dinâmica por nome nas tabelas (filtro feito em JavaScript, sem recarregar a página)
- Confirmação antes de excluir qualquer registro
- Validação de campos obrigatórios nos formulários

### Integridade dos dados
- Não é possível excluir um continente que ainda tenha países vinculados
- Não é possível excluir um país que ainda tenha cidades vinculadas
- Ao excluir um governante, os países e cidades ligados a ele não são apagados: o campo de governante fica vazio

### Autenticação e segurança
- Login com username e senha
- Senhas armazenadas criptografadas (hash), nunca em texto puro
- Bloqueio automático do usuário após 3 tentativas de senha incorreta consecutivas
- Troca de senha obrigatória no primeiro acesso
- Logout com encerramento da sessão
- Páginas protegidas: quem não está logado é redirecionado para a tela de login

### Controle de permissões
| Tipo de usuário | O que pode fazer |
|---|---|
| Administrador | Consultar, cadastrar, editar e excluir todos os registros |
| Usuário comum | Apenas consultar (os formulários e os botões de editar/excluir não aparecem, e as ações também são bloqueadas no servidor) |

### Registro de logs
O sistema grava na tabela `logs` as principais ações realizadas: logins, tentativas incorretas, bloqueios, trocas de senha, logouts e cadastros, edições e exclusões de dados, sempre identificando o usuário responsável.

### Interface
- Tema escuro, com fonte Arial em todas as páginas
- Layout responsivo (a tabela se adapta para telas pequenas)
- Menu de navegação com destaque da página atual
- Nome e tipo do usuário logado exibidos no cabeçalho

## Tecnologias utilizadas
- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Git
- GitHub

## Estrutura do projeto
```
CRUD-MUNDO/
├── index.php            → página inicial (após o login)
├── login.php            → tela de login e validação de acesso
├── logout.php           → encerra a sessão do usuário
├── trocar_senha.php     → troca de senha (obrigatória no primeiro acesso)
├── criar_admin.php      → cria o primeiro usuário administrador
├── config/
│   ├── database.php     → conexão com o banco de dados
│   └── auth.php         → controle de sessão, permissões e registro de logs
├── includes/
│   ├── header.php       → cabeçalho e menu, reutilizados em todas as páginas
│   └── footer.php       → rodapé e chamada do JavaScript
├── css/
│   └── style.css        → estilos do sistema
├── js/
│   └── script.js        → confirmação de exclusão, validação de formulários e busca dinâmica
├── database/
│   └── bd_mundo.sql     → script de criação do banco de dados
└── paginas/
    ├── continentes.php  → CRUD de continentes
    ├── paises.php       → CRUD de países
    ├── cidades.php      → CRUD de cidades
    └── governantes.php  → CRUD de governantes
```

## Banco de dados
O banco se chama `bd_mundo` e possui 6 tabelas:

| Tabela | Descrição | Relacionamentos |
|---|---|---|
| `continentes` | Nome, população, área e total de países | Um continente possui vários países |
| `governantes` | Nome, partido político, data de nascimento, idade e datas de início e fim do mandato | Um governante pode governar países e cidades |
| `paises` | Nome, população, área, idioma, clima, regime político e moeda | Pertence a um continente e pode ter um governante |
| `cidades` | Nome, população, área, clima e data de fundação | Pertence a um país e pode ter um governante |
| `usuarios` | Username, senha (hash), nome, status, tipo, quantidade de acessos incorretos e controle de primeiro acesso | Um usuário pode ter vários logs |
| `logs` | Data/hora, descrição da ação e username | Pertence a um usuário |

**Códigos usados na tabela `usuarios`:**
- `status`: `A` = Ativo, `I` = Inativo, `B` = Bloqueado
- `tipo`: `A` = Administrador, `U` = Usuário comum
- `primeiro_acesso`: `S` = ainda precisa trocar a senha, `N` = já trocou

## Requisitos
- PHP
- MySQL
- Servidor local com Apache (XAMPP, WAMP ou similar)
- Navegador atualizado
- Git (para clonar o repositório)

## Como executar
1. Clone o repositório:
```
   git clone https://github.com/JoseMartins08/PROJETO_WEB.git
```
2. Copie a pasta `CRUD-MUNDO` para dentro do `htdocs` (XAMPP) ou `www` (WAMP).
3. Inicie o **Apache** e o **MySQL** pelo painel do XAMPP/WAMP.
4. Importe o arquivo `database/bd_mundo.sql` no MySQL (pelo phpMyAdmin ou pelo MySQL Workbench). Ele cria o banco `bd_mundo` e todas as tabelas.
5. Confira o usuário e a senha do banco em `config/database.php`. Por padrão estão como `root` e senha vazia, que é o padrão do XAMPP. Ajuste se o seu MySQL for diferente.
6. Acesse `http://localhost/CRUD-MUNDO/criar_admin.php` e crie o primeiro usuário administrador.
7. **Apague o arquivo `criar_admin.php`** depois de criar o administrador, para que ninguém mais consiga usá-lo.
8. Acesse `http://localhost/CRUD-MUNDO/login.php` e entre com o usuário criado.

## Como usar
- **Administrador:** use o menu para acessar Continentes, Países, Cidades e Governantes. Preencha o formulário no topo da página e clique em **Salvar** para cadastrar. Use **Editar** para carregar os dados de um registro no formulário e **Excluir** para remover (o sistema pede confirmação).
- **Usuário comum:** acessa as mesmas páginas, mas só vê as listas. Pode usar o campo de busca para filtrar por nome.
- **Usuário bloqueado:** depois de 3 senhas erradas seguidas, o acesso é bloqueado e só pode ser liberado alterando o status direto no banco de dados.
- **Primeiro acesso:** usuários criados com `primeiro_acesso = 'S'` são levados automaticamente para a tela de troca de senha após o login.

## Interface
_Adicione aqui prints das telas do sistema (tela de login, tela inicial, cadastro de países, etc.)._

## Autor
José Eduardo Elhage Martins
Técnico em Desenvolvimento de Sistemas, ETEC