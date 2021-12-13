# Host: localhost  (Version 5.5.5-10.4.14-MariaDB)
# Date: 2021-12-13 11:24:35
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

REPLACE INTO `users` (`id`,`nome`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'David Chagas','davidmdchagas@hotmail.com',NULL,'$2y$10$rsWC.YKQnWcDeiaR0KGLb.B/Yvc.l986JP.bwX7sJ6Jk4EWwcUYxy',NULL,'2021-12-13 13:58:53','2021-12-13 13:58:53');

#
# Data for table "objetivos"
#

REPLACE INTO `objetivos` (`id`,`nome`,`descricao`,`valor`,`data_inicial`,`data_final`,`arquivado`,`usuario_id`) VALUES (1,'Viagem (Férias de 2022)',NULL,500000,'2021-11-20','2022-12-20',0,1);

#
# Data for table "objetivo_aportes"
#

REPLACE INTO `objetivo_aportes` (`id`,`valor`,`data`,`objetivo_id`) VALUES (1,50000,'2021-11-20',1);

#
# Data for table "contas"
#

REPLACE INTO `contas` (`id`,`descricao`,`valor`,`arquivado`,`usuario_id`) VALUES (1,'Carteira',20000,0,1),(2,'Caixa (Poupança)',250000,0,1),(3,'NuConta',230000,0,1);

#
# Data for table "categorias"
#

REPLACE INTO `categorias` (`id`,`descricao`,`tipo`,`arquivado`,`usuario_id`) VALUES (1,'Salário','Receita',0,1),(2,'Bônus','Receita',0,1),(3,'Transporte','Despesa',0,1),(4,'Outros','Receita',0,1),(5,'Outros','Despesa',0,1),(6,'Saúde','Despesa',0,1),(7,'Alimentação','Despesa',0,1),(8,'Lazer','Despesa',0,1);

#
# Data for table "receitas"
#

REPLACE INTO `receitas` (`id`,`valor`,`status`,`data`,`descricao`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1,250000,'pago','2021-11-05','Pagamento',NULL,1,3,1),(2,50000,'pago','2021-11-05','PPR',NULL,1,1,2);

#
# Data for table "despesas"
#

REPLACE INTO `despesas` (`id`,`valor`,`status`,`data`,`descricao`,`observacao`,`usuario_id`,`conta_id`,`categoria_id`) VALUES (1,15000,'pago','2021-11-10','Dentista',NULL,1,1,6),(2,4000,'pago','2021-11-15','Uber',NULL,1,3,3),(3,15000,'pago','2021-11-25','Compras Supermercado',NULL,1,1,7),(4,6000,'pago','2021-11-18','Cinema',NULL,1,3,8),(5,10000,'pago','2021-11-06','Academia',NULL,1,3,6);
