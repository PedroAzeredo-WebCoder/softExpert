
# Projeto SoftExpert

Este é o projeto SoftExpert, um sistema de gerenciamento de produtos. A seguir, descrevemos como rodar o projeto e como realizar os cadastros dentro do mesmo.

## Rodando o projeto

Para rodar o projeto, siga os seguintes passos:

### Instalando as dependências

2. Instale as dependências do projeto e compile-o, utilizando o seguinte comando:
   
   ```
   npm install && npx mix
   ```

### Configurando o banco de dados

3. Configure o banco de dados do projeto, para isso, siga os seguintes passos:

   a) Instale o PostgreSQL e o pgAdmin em sua máquina;
   
   b) Abra o pgAdmin e crie um novo banco de dados com o nome "softexpert";
   
   c) Na raiz do projeto, localize o arquivo `dump.sql` na pasta `dump` e restaure o banco de dados, clicando em `Restore` no pgAdmin e selecionando o arquivo `dump.sql`.
   
### Executando o servidor web

4. Execute o servidor web, para isso, rode o seguinte comando na raiz do projeto:
    ```
   php -S localhost:8080
   ```
   
5. Acesse o sistema no seu navegador através do endereço `http://localhost:8080`.

## Realizando cadastros

O sistema permite o cadastro de dois tipos de entidades: `usuários`, `produtos` e `tipos de produtos`.

OBS: O sistema obtem validação de auth, então, para acessar o sistema pela primeira vez, utilize os seguintes acessos:
   ```
   pedro.azeredo93@gmail.com
   254887
   ```
   Após o login, podemos criar um cadastro de um usuário para ter um acesso separado.

### Cadastro de usuários

Para cadastrar um novo usuário, siga os seguintes passos:

1. No menu lateral do sistema, clique na opção `Usuários`.

2. Na tela de usuários, clique no botão `Novo`.

3. Preencha o formulário de cadastro do usuário com as informações necessárias, como nome, email, senha, entre outras.

4. Clique no botão `Salvar` para salvar o usuário.

### Cadastro de tipos de produtos

Para cadastrar um tipo de produto, siga os seguintes passos:

1. No menu lateral do sistema, clique na opção `Tipos de Produtos`.

2. Na tela de tipos de produtos, clique no botão `Novo`.

3. Preencha o formulário de cadastro da categoria com as informações necessárias, como nome, percentual de imposto e descrição.

4. Clique no botão `Salvar` para salvar o novo tipo de produto.

### Cadastro de produtos

Para cadastrar um novo produto, siga os seguintes passos:

1. No menu lateral do sistema, clique na opção `Produtos`.

2. Na tela de produtos, clique no botão `Novo`.

3. Preencha o formulário de cadastro do produto com as informações necessárias, como nome, preço, quantidade, tipo de produto.

Segue a continuação da melhoria do arquivo README.md:

## Funcionalidades

O projeto SoftExpert possui as seguintes funcionalidades:

- Cadastro de usuários, produtos e tipos de produtos.
- Visualização, edição e exclusão de usuários, produtos e tipos de produtos.
- Adição de produtos ao carrinho.
- Cálculo do valor total da compra, considerando a quantidade de produtos e o valor do imposto de cada tipo de produto.
- Finalização da compra.

## Próximos passos

Algumas melhorias que podem ser implementadas no projeto incluem:

- Adição de filtros de pesquisa nas telas de listagem de usuários, produtos e tipos de produtos.
- Melhoria na interface do usuário, com a adição de um design responsivo e mais amigável.
- Aplicação de soft delete para os cadastros.
