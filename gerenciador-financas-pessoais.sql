# Host: localhost  (Version 5.5.5-10.4.14-MariaDB)
# Date: 2021-11-21 22:37:27
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Data for table "failed_jobs"
#


#
# Data for table "migrations"
#

REPLACE INTO `migrations` (`id`,`migration`,`batch`) VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_09_01_233534_create_contas_table',1),(6,'2021_09_02_000001_create_categorias_table',1),(7,'2021_09_02_002057_create_receitas_table',1),(8,'2021_09_02_002105_create_despesas_table',1),(9,'2021_10_30_133713_create_objetivos_table',1),(10,'2021_11_02_232832_create_objetivo_aportes_table',1);

#
# Data for table "password_resets"
#


#
# Data for table "personal_access_tokens"
#


#
# Data for table "users"
#

REPLACE INTO `users` (`id`,`nome`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'David Chagas','davidmdchagas@hotmail.com',NULL,'$2y$10$pFkUvuknrax/Nr79QGsKEOoEjMZ35NnmuCCrZ8Nt7hrHAFY0wLM.u',NULL,'2021-11-22 01:25:41','2021-11-22 01:25:41');

#
# Data for table "objetivos"
#

REPLACE INTO `objetivos` (`id`,`nome`,`descricao`,`valor`,`data_inicial`,`data_final`,`usuario_id`) VALUES (1,'Comprar Iphone',NULL,1500000,'2021-11-22','2022-06-01',1);

#
# Data for table "objetivo_aportes"
#

REPLACE INTO `objetivo_aportes` (`id`,`valor`,`data`,`objetivo_id`) VALUES (1,150000,'2021-11-21',1),(2,60000,'2021-11-21',1),(3,35000,'2021-11-21',1),(4,85000,'2021-11-21',1),(5,150000,'2021-11-21',1);

#
# Data for table "contas"
#

REPLACE INTO `contas` (`id`,`descricao`,`valor`,`usuario_id`) VALUES (1,'Carteira',360000,1),(2,'NuConta',70000,1);

#
# Data for table "categorias"
#

REPLACE INTO `categorias` (`id`,`descricao`,`tipo`,`usuario_id`) VALUES (1,'Salário','Receita',1),(2,'Transporte','Despesa',1),(3,'Educação','Despesa',1),(4,'Bonus','Receita',1),(5,'Lazer','Despesa',1);

#
# Data for table "receitas"
#

REPLACE INTO `receitas` (`id`,`valor`,`status`,`data`,`descricao`,`receita_fixa`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1,250000,'pago','2021-11-05','Pagamento','sim',NULL,1,2,1),(2,250000,'pago','2021-10-05','Salário','sim',NULL,1,1,1),(3,55000,'pago','2021-10-12','PPR','nao',NULL,1,1,4),(4,65000,'pago','2021-11-10','PPR','nao',NULL,1,1,4);

#
# Data for table "despesas"
#

REPLACE INTO `despesas` (`id`,`valor`,`status`,`data`,`descricao`,`despesa_fixa`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1,55000,'pago','2021-11-10','Onibus','nao',NULL,1,1,2),(2,80000,'pago','2021-11-06','Faculdade','sim',NULL,1,2,3),(3,35000,'pago','2021-10-11','Transporte','nao',NULL,1,1,2),(4,200000,'pago','2021-10-14','Viajem','nao',NULL,1,2,5),(5,20000,'pago','2021-11-13','Festa','nao',NULL,1,1,5);
