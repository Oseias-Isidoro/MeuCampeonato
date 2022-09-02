***REQUISITOS***

1. PHP 8
2. LARAVEL 9
3. PYTHON (foi utilizado para teste a versão 3.10.4)
4. Banco de dados que foi utilizado 10.4.24-MariaDB

***COMO O SISTEMA GERA OS GOLS***

através de um script python

***COMO O SISTEMA LIDA COM EMPATES***

o sistema roda um loop de pênaltis até que o empate seja resolvido
```php
// Esse while representa as cobranças de pênaltis, o loop continuara até que o empate seja resolvido
while ($this->isTied($goals)) {
    $this->penaltyKicks($goals);
}
```

****COMO EXECUTAR O PROJETO****

1. Clone o projeto
2. Na raiz do projeto execute ***composer install***
3. Renomear o arquivo .env.exemplo para .env
4. Criar um banco de dados e adicionar as credenciar no arquivo .env
5. Executar o comando ***php artisan key:generate*** 
6. Executar o comando ***php artisan migrate***
7. Executar o comando ***php artisan test***
8. Executar o comando ***php artisan serve***, abra o sistema no navegado e sera possível  ver a home do sistema
<img src="https://github.com/Oseias-Isidoro/MeuCampeonato/blob/main/Captura%20de%20tela%202022-09-01%20172901.png?raw=true" width="400">

9. Abra o programa ***insomnia*** e faça a importação do arquivo ***Insomnia_2022-09-01.json*** que esta na raiz do projeto
10. No programa ***insomnia*** na pasta ***Leagues*** request ***create***
11. execute um request passando o parâmetro  ***name***, o valor deste parâmetro sera o nome do campeonato, se ocorrer tudo bem a resposta sera assim:

```json
{
	"name": "Copa Libertadores",
	"slug": "copa-libertadores",
	"updated_at": "2022-09-01T20:34:00.000000Z",
	"created_at": "2022-09-01T20:34:00.000000Z",
	"id": 1
}
```

Agora na home do sistema sera possível ver um campeonato, mas não sera possível clicar nele poque ainda está pendente

<img src="https://github.com/Oseias-Isidoro/MeuCampeonato/blob/main/Captura%20de%20tela%202022-09-01%20184711.png?raw=true" width="400">

12.No programa ***insomnia*** na pasta ***Leagues Teams*** request ***create***, execute um request passando na url o ***id*** do campeonato que acabou de criar, passando o parâmetro ***name***, o valor deste parâmetro sera o nome do time, se ocorrer tudo bem a resposta sera assim:
```url
http://localhost:8000/api/league/{id do campeonado}/teams?name=Santos
```

```json
    {
	"name": "Santos",
	"slug": "santos",
	"league_id": 1,
	"updated_at": "2022-09-01T21:00:10.000000Z",
	"created_at": "2022-09-01T21:00:10.000000Z",
	"id": 1
}
```
crie 8 times para o campeonato, se tentar criar mais de oito times recebera o seguinte erro:
```json
{
	"message": "um campeonato não pode ter mais de 8 times"
}
```

13. agora executaremos a simulação do campeonato, no programa ***insomnia*** na pasta ***Leagues*** request ***simulate***, execute um request passando na url o ***id*** do campeonato que acabou de criar
```url
http://localhost:8000/api/leagues/1/simulate
```
response:
```json
{
	"league": {
		"id": 1,
		"name": "Copa Libertadores",
		"slug": "copa-libertadores",
		"status": "finished",
		"deleted_at": null,
		"created_at": "2022-09-01T20:34:00.000000Z",
		"updated_at": "2022-09-01T21:09:46.000000Z"
	},
	"quarter": {
		"winners": [
			{
				"id": 2,
				"league_id": 1,
				"name": "Palmeiras",
				"slug": "palmeiras",
				"goals": 6,
				"goals_taken": 0,
				"phase": "quarterfinals",
				"status": "active",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:08.000000Z",
				"updated_at": "2022-09-01T21:09:45.000000Z"
			},
			{
				"id": 1,
				"league_id": 1,
				"name": "Santos",
				"slug": "santos",
				"goals": 7,
				"goals_taken": 2,
				"phase": "quarterfinals",
				"status": "active",
				"deleted_at": null,
				"created_at": "2022-09-01T21:00:10.000000Z",
				"updated_at": "2022-09-01T21:09:45.000000Z"
			},
			{
				"id": 7,
				"league_id": 1,
				"name": "Internacional",
				"slug": "internacional",
				"goals": 7,
				"goals_taken": 0,
				"phase": "quarterfinals",
				"status": "active",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:50.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			},
			{
				"id": 4,
				"league_id": 1,
				"name": "Fluminense",
				"slug": "fluminense",
				"goals": 3,
				"goals_taken": 1,
				"phase": "quarterfinals",
				"status": "active",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:23.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		],
		"losers": [
			{
				"id": 3,
				"league_id": 1,
				"name": "Flamengo",
				"slug": "flamengo",
				"goals": 0,
				"goals_taken": 6,
				"phase": "quarterfinals",
				"status": "eliminated",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:16.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			},
			{
				"id": 8,
				"league_id": 1,
				"name": "Athletico-PR",
				"slug": "athletico-pr",
				"goals": 2,
				"goals_taken": 7,
				"phase": "quarterfinals",
				"status": "eliminated",
				"deleted_at": null,
				"created_at": "2022-09-01T21:05:00.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			},
			{
				"id": 6,
				"league_id": 1,
				"name": "Cascavel FC",
				"slug": "cascavel-fc",
				"goals": 0,
				"goals_taken": 7,
				"phase": "quarterfinals",
				"status": "eliminated",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:41.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			},
			{
				"id": 5,
				"league_id": 1,
				"name": "Corinthians",
				"slug": "corinthians",
				"goals": 1,
				"goals_taken": 3,
				"phase": "quarterfinals",
				"status": "eliminated",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:30.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		]
	},
	"semifinals": {
		"winners": [
			{
				"id": 1,
				"league_id": 1,
				"name": "Santos",
				"slug": "santos",
				"goals": 11,
				"goals_taken": 3,
				"phase": "semifinals",
				"status": "active",
				"deleted_at": null,
				"created_at": "2022-09-01T21:00:10.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			},
			{
				"id": 4,
				"league_id": 1,
				"name": "Fluminense",
				"slug": "fluminense",
				"goals": 9,
				"goals_taken": 4,
				"phase": "semifinals",
				"status": "active",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:23.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		],
		"losers": [
			{
				"id": 2,
				"league_id": 1,
				"name": "Palmeiras",
				"slug": "palmeiras",
				"goals": 7,
				"goals_taken": 4,
				"phase": "semifinals",
				"status": "eliminated",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:08.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			},
			{
				"id": 7,
				"league_id": 1,
				"name": "Internacional",
				"slug": "internacional",
				"goals": 10,
				"goals_taken": 6,
				"phase": "semifinals",
				"status": "eliminated",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:50.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		]
	},
	"third_place": {
		"winners": [
			{
				"id": 2,
				"league_id": 1,
				"name": "Palmeiras",
				"slug": "palmeiras",
				"goals": 14,
				"goals_taken": 7,
				"phase": "third_place",
				"status": "third",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:08.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		],
		"losers": [
			{
				"id": 7,
				"league_id": 1,
				"name": "Internacional",
				"slug": "internacional",
				"goals": 13,
				"goals_taken": 13,
				"phase": "third_place",
				"status": "eliminated",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:50.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		]
	},
	"final": {
		"winners": [
			{
				"id": 1,
				"league_id": 1,
				"name": "Santos",
				"slug": "santos",
				"goals": 13,
				"goals_taken": 4,
				"phase": "final",
				"status": "champion",
				"deleted_at": null,
				"created_at": "2022-09-01T21:00:10.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		],
		"losers": [
			{
				"id": 4,
				"league_id": 1,
				"name": "Fluminense",
				"slug": "fluminense",
				"goals": 10,
				"goals_taken": 6,
				"phase": "final",
				"status": "second",
				"deleted_at": null,
				"created_at": "2022-09-01T21:04:23.000000Z",
				"updated_at": "2022-09-01T21:09:46.000000Z"
			}
		]
	}
}
```
se você voltar ao navegador vera que o campeonato não está como pendente, e pode ser clicado
<img src="https://github.com/Oseias-Isidoro/MeuCampeonato/blob/main/image.png?raw=true" width="400">

se abrindo o campeonato vera as tabelas de resultado do campeonato

<img src="https://github.com/Oseias-Isidoro/MeuCampeonato/blob/main/Captura%20de%20tela%202022-09-01%20184329.png?raw=true" width="400">

se tentar simular um campeonato já simulado recebera o seguinte erro:
```json
{
	"message": "Este campeonato já foi simulado"
}
```

se tentar simular um campeonato que não tenha exatos 8 times recebera o erro:
```json
{
	"message": "Para simular o campeonato ele deve ter exatos 8 times"
}
```

14. O programa utiliza python para gerar os gols de forma randômica, caso tenha algum problema em executar o código python recebera o erro:
```json
{
    "message": "Error executing python code"
}
```
