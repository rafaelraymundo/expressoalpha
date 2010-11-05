/* ESSAS TABELAS SERAO INCLUIDAS PARA SEREM INSTALADAS JUNTAMENTE COM A FERRAMENTA*/
/********* CRIANDO AS SEQUENCES ***************************************************/

/********* CRIANDO AS SEQUENCES *****************/

CREATE SEQUENCE seq_egw_wf_agile_projects
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

CREATE SEQUENCE seq_egw_wf_agile_tasks
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

CREATE SEQUENCE seq_egw_wf_agile_users_projects
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

CREATE SEQUENCE seq_egw_wf_agile_sprints
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

ALTER TABLE public.seq_egw_wf_agile_projects OWNER TO postgres;
ALTER TABLE public.seq_egw_wf_agile_tasks OWNER TO postgres;
ALTER TABLE public.seq_egw_wf_agile_users_projects OWNER TO postgres;
ALTER TABLE public.seq_egw_wf_agile_sprints OWNER TO postgres;

SELECT pg_catalog.setval('seq_egw_wf_agile_projects', 1, false);
SELECT pg_catalog.setval('seq_egw_wf_agile_tasks', 1, false);
SELECT pg_catalog.setval('seq_egw_wf_agile_users_projects', 1, false);
SELECT pg_catalog.setval('seq_egw_wf_agile_sprints', 1, false);

/****************CRIANDO AS TABELAS***************/

CREATE TABLE phpgw_agile_projects (
	proj_id integer DEFAULT nextval('seq_egw_wf_agile_projects'::regclass) PRIMARY KEY NOT NULL,
	proj_name varchar (100) NOT NULL,
	proj_description varchar (255),
	proj_owner varchar (20)
);

CREATE TABLE phpgw_agile_sprints(
	sprints_id integer DEFAULT nextval('seq_egw_wf_agile_sprints'::regclass) PRIMARY KEY NOT NULL,
	sprints_proj_id integer references phpgw_agile_projects(proj_id) ON DELETE CASCADE NOT NULL,
	sprints_name varchar (100) NOT NULL,
	sprints_goal varchar (255) NOT NULL,
	sprints_dt_start date NOT NULL,
	sprints_dt_end date NOT NULL,
	sprints_retrospective varchar (255) NOT NULL
);

CREATE TABLE phpgw_agile_tasks(
	tasks_id integer DEFAULT nextval('seq_egw_wf_agile_tasks'::regclass) PRIMARY KEY NOT NULL,
	tasks_id_sprints integer references phpgw_agile_sprints(sprints_id) ON DELETE CASCADE,
	tasks_id_proj integer references phpgw_agile_projects(proj_id) ON DELETE CASCADE,
	tasks_id_owner integer,
	tasks_title varchar (255),
	tasks_subtitle varchar (255),
	tasks_description varchar (255),
	tasks_status varchar(10)
);

CREATE TABLE phpgw_agile_users_projects(uprojects_id_user varchar(100) NOT NULL,
uprojects_id_project integer NOT NULL,
uprojects_user_admin boolean NOT NULL, 
uprojects_active boolean NOT NULL,
FOREIGN KEY(uprojects_id_project) references phpgw_agile_projects(proj_id) ON DELETE CASCADE
);

/* ALTERANDO AS PERMISSÕES */
ALTER TABLE public.phpgw_agile_projects OWNER TO postgres;
ALTER TABLE public.phpgw_agile_sprints OWNER TO postgres;
ALTER TABLE public.phpgw_agile_tasks OWNER TO postgres;
ALTER TABLE public.phpgw_agile_users_projects OWNER TO postgres;

