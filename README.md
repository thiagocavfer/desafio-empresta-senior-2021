# Empresta API #

### Comandos a serem executados após clonagem do projeto:
- ```composer install```
- ```cp .env.example .env```
- ```php artisan key:generate```
- ```php artisan serve --port=8000```

### Endereço de acesso a aplicação:
- ```http://localhost:8000```

### Endpoints
| Endereço                	| Interface 	| Método 	| Payload                                                                         	|     Descrição                                                                         	|
|-------------------------	|-----------	|--------	|---------------------------------------------------------------------------------	|------------------------------------------------------------------------------	|
| /api/instituicoes       	| API       	| GET    	| ---                                                                             	| Rertorna um objeto json com todas as instituições.                           	|
| /api/convenios          	| API       	| GET    	| ---                                                                             	| Rertorna um objeto json com todas os convênios.                              	|
| /api/emprestimo/simular 	| API       	| POST   	| {"valor_emprestimo": 1500,  "instituicoes":[], "convenios":[], "parcelas": [] } 	| Retorna um array de objetos json com o resultado da simulação de emprestimo. 	|
| /api/documentation          	| WEB       	| GET    	| ---                                                                             	| Documentação da API com Swagger.                                             	|
 

