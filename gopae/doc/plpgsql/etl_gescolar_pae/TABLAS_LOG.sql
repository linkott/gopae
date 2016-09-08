-- Table: auditoria_etls.log_autoridad_plantel

-- DROP TABLE auditoria_etls.log_autoridad_plantel;

CREATE TABLE auditoria_etls.log_autoridad_plantel
(
  id bigserial NOT NULL,
  plantel_id integer,
  usuario_id integer,
  cargo_id integer,
  observacion character varying(150),
  usuario_ini_id integer,
  fecha_ini timestamp(6) without time zone DEFAULT (now())::timestamp(0) without time zone,
  usuario_act_id integer,
  fecha_elim timestamp(6) without time zone,
  estatus character varying(1),
  periodo_id integer,
  resultado character varying(10),
  mensaje text,
  fecha timestamp without time zone,
  operacion character varying(10)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE auditoria_etls.log_autoridad_plantel
  OWNER TO postgres;

  --------------------------------------------------

  -- Table: auditoria_etls.log_group

-- DROP TABLE auditoria_etls.log_group;

CREATE TABLE auditoria_etls.log_group
(
  id bigserial NOT NULL,
  groupname character varying(60) NOT NULL,
  level integer,
  home character varying(120) DEFAULT NULL::character varying,
  user_ini_id integer,
  date_ini timestamp without time zone DEFAULT (now())::timestamp(0) without time zone,
  estatus character varying(1) NOT NULL DEFAULT 'A'::character varying,
  date_del timestamp without time zone,
  resultado character varying(10),
  mensaje text,
  fecha timestamp without time zone,
  operacion character varying(10)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE auditoria_etls.log_group
  OWNER TO postgres;


------------------------------------------------------------

-- Table: auditoria_etls.log_plantel

-- DROP TABLE auditoria_etls.log_plantel;

CREATE TABLE auditoria_etls.log_plantel
(
  id bigserial NOT NULL,
  cod_estadistico bigint,
  cod_plantel character varying(16),
  planta_fisica_id integer,
  nombre character varying(150),
  denominacion_id integer,
  tipo_dependencia_id integer,
  estado_id integer,
  municipio_id integer,
  parroquia_id integer,
  localidad_id integer,
  direccion text,
  distrito_id integer,
  zona_educativa_id integer,
  modalidad_id integer,
  nivel_id integer,
  condicion_estudio_id integer,
  correo character varying(100),
  telefono_fijo character varying(20),
  telefono_otro character varying(20),
  director_actual_id integer,
  director_supl_actual_id integer,
  subdirector_actual_id integer,
  subdirector_supl_actual_id integer,
  coordinador_actual_id integer,
  coordinador_supl_actual_id integer,
  clase_plantel_id integer,
  condicion_infra_id integer,
  categoria_id integer,
  posee_electricidad boolean,
  posee_edificacion boolean,
  logo character varying(255),
  observacion text,
  es_tecnica boolean,
  especialidad_tec_id integer,
  usuario_ini_id integer,
  fecha_ini timestamp(6) without time zone DEFAULT (now())::timestamp(0) without time zone,
  fecha_elim timestamp(6) without time zone,
  estatus character varying(1) NOT NULL DEFAULT 'A'::character varying,
  estatus_plantel_id integer,
  latitud double precision,
  longitud double precision,
  annio_fundado integer,
  turno_id integer,
  genero_id integer,
  zona_ubicacion_id integer,
  nfax character varying(15),
  codigo_ner character varying(10),
  cod_unico integer,
  cod_plantel_anterior character varying(15),
  poblacion_id integer,
  urbanizacion_id integer,
  tipo_via_id integer,
  via character varying(70),
  mensaje text,
  fecha timestamp without time zone,
  operacion character varying(10),
  resultado character varying(10)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE auditoria_etls.log_plantel
  OWNER TO postgres;


-------------------------------------------------------------------

-- Table: auditoria_etls.log_user
-- Table: auditoria_etls.log_user

-- DROP TABLE auditoria_etls.log_user;

CREATE TABLE auditoria_etls.log_user
(
  id bigserial NOT NULL,
  cedula integer NOT NULL,
  username character varying(120) NOT NULL,
  password character varying(300) NOT NULL,
  email character varying(120) NOT NULL,
  home character varying(120) DEFAULT NULL::character varying,
  question text,
  answer text,
  creation_date timestamp without time zone DEFAULT (now())::timestamp(0) without time zone,
  activation_code character varying(30) DEFAULT NULL::character varying,
  activation_time timestamp without time zone,
  last_login timestamp without time zone,
  ban timestamp without time zone,
  ban_reason text,
  telefono character varying(14),
  nombre character varying(40) NOT NULL,
  apellido character varying(40),
  direccion character varying,
  estado_id integer NOT NULL,
  user_ini_id bigint,
  date_ini timestamp without time zone NOT NULL DEFAULT (now())::timestamp(0) without time zone,
  date_act timestamp without time zone,
  user_ban_id bigint,
  last_ip_address character varying(40),
  origen character varying(1),
  clave_anterior character varying(255),
  cambio_clave smallint DEFAULT 0,
  twitter character varying(40),
  telefono_celular character varying(14),
  mensaje text,
  fecha timestamp without time zone,
  operacion character varying(10),
  resultado character varying(10)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE auditoria_etls.log_user
  OWNER TO postgres;
