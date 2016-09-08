-- Table: gplantel.colaborador_plantel

-- DROP TABLE gplantel.colaborador_plantel;

CREATE TABLE gplantel.colaborador_plantel
(
  id serial NOT NULL,
  colaborador_id integer,
  plantel_id integer NOT NULL,
  periodo_id integer NOT NULL,
  usuario_ini_id integer NOT NULL,
  fecha_ini timestamp without time zone NOT NULL DEFAULT (now())::timestamp(0) without time zone,
  usuario_act_id integer,
  fecha_act timestamp without time zone,
  fecha_elim timestamp without time zone,
  estatus character varying(1) NOT NULL,
  CONSTRAINT colaborador_plantel_periodo_pk PRIMARY KEY (id ),
  CONSTRAINT colaborador_plant_colaborador_id_fk3 FOREIGN KEY (colaborador_id)
      REFERENCES gplantel.colaborador (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT colaborador_plant_periodo_id_fk4 FOREIGN KEY (periodo_id)
      REFERENCES gplantel.periodo_escolar (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT colaborador_plantel_id_fk1 FOREIGN KEY (plantel_id)
      REFERENCES gplantel.plantel (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT colaborador_plantel_usuario_act_fk2 FOREIGN KEY (usuario_act_id)
      REFERENCES seguridad.usergroups_user (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT colaborador_plantel_usuario_ini_fk1 FOREIGN KEY (usuario_ini_id)
      REFERENCES seguridad.usergroups_user (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT colaborador_uk1 UNIQUE (colaborador_id , plantel_id , periodo_id ),
  CONSTRAINT colaborador_plantel_periodo_estatus_check CHECK (estatus::text = ANY (ARRAY['A'::character varying::text, 'I'::character varying::text, 'E'::character varying::text]))
)
WITH (
  OIDS=FALSE
);
ALTER TABLE gplantel.colaborador_plantel
  OWNER TO postgres;

-- Index: gplantel.colaborador_plantel_colaborador_id_idx

-- DROP INDEX gplantel.colaborador_plantel_colaborador_id_idx;

CREATE INDEX colaborador_plantel_colaborador_id_idx
  ON gplantel.colaborador_plantel
  USING btree
  (colaborador_id );

-- Index: gplantel.colaborador_plantel_periodo_id_idx

-- DROP INDEX gplantel.colaborador_plantel_periodo_id_idx;

CREATE INDEX colaborador_plantel_periodo_id_idx
  ON gplantel.colaborador_plantel
  USING btree
  (periodo_id );

-- Index: gplantel.colaborador_plantel_plantel_id_idx

-- DROP INDEX gplantel.colaborador_plantel_plantel_id_idx;

CREATE INDEX colaborador_plantel_plantel_id_idx
  ON gplantel.colaborador_plantel
  USING btree
  (plantel_id );


-- Trigger: on_insert_colaborador_plantel_trigger on gplantel.colaborador_plantel

-- DROP TRIGGER on_insert_colaborador_plantel_trigger ON gplantel.colaborador_plantel;

CREATE TRIGGER on_insert_colaborador_plantel_trigger
  BEFORE INSERT
  ON gplantel.colaborador_plantel
  FOR EACH ROW
  EXECUTE PROCEDURE gplantel.insert_colaborador_plantel();



CREATE OR REPLACE FUNCTION gplantel.insert_colaborador_plantel()
    RETURNS trigger AS
$BODY$
DECLARE
    v_nombre_tabla character varying :='colaborador_plantel_p';
    v_nombre_esquema character varying  :='gplantel_part';
    v_periodo_id smallint;
    v_periodo_actual_id smallint;
    v_existe_tabla smallint :=0;
    v_insert_tabla character varying;
    v_plantel_id integer;
    v_colaborador_id integer;
    v_usuario_ini_id integer;
    v_estatus character varying(1) := 'A';

    v_sql text;

BEGIN

    v_periodo_id := NEW.periodo_id;
    v_plantel_id := NEW.plantel_id;
    v_colaborador_id :=NEW.colaborador_id;
    v_usuario_ini_id :=NEW.usuario_ini_id;
    v_nombre_tabla :=v_nombre_tabla||v_periodo_id;
    v_insert_tabla :=v_nombre_esquema||'.'||v_nombre_tabla;

    SELECT COUNT(tablename) INTO v_existe_tabla FROM pg_tables WHERE schemaname = v_nombre_esquema AND tablename=v_nombre_tabla;
    IF(v_existe_tabla = 1) THEN

        v_sql := 'INSERT INTO '||v_insert_tabla||'(periodo_id, plantel_id, colaborador_id, usuario_ini_id, estatus) VALUES ('||v_periodo_id||', '||v_plantel_id||', '||v_colaborador_id||', '||v_usuario_ini_id||')';
        EXECUTE v_sql;

    ELSE
        RETURN NULL;
    END IF;

    RETURN NEW;

EXCEPTION WHEN others THEN
    -- WHEN not_null_violation THEN
    --         RAISE EXCEPTION 'Todos los campos son requeridos';
    --     WHEN foreign_key_violation THEN
    --         RAISE EXCEPTION '';
    --     WHEN string_data_right_truncation THEN
    --         RAISE EXCEPTION '';
    --     WHEN unique_violation THEN
    --         RAISE EXCEPTION '';
    RAISE EXCEPTION 'Ha Ocurrido un Error en el SP gplantel.insert_colaborador_plantel() : (on_insert_colaborador_plantel_trigger) : % %',SQLERRM, SQLSTATE;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION matricula.insert_colaborador_plantel()
  OWNER TO postgres;

CREATE TRIGGER on_insert_colaborador_plantel_trigger
  BEFORE INSERT
  ON gplantel.colaborador_plantel
  FOR EACH ROW
  EXECUTE PROCEDURE gplantel.insert_colaborador_plantel();

CREATE TABLE gplantel_part.colaborador_plantel_pxxx
(
    CONSTRAINT gplantel_part.colaborador_plantel_pxxx CHECK (periodo_id = xxx)
)
INHERITS (gplantel.colaborador_plantel)
WITH (
  OIDS = FALSE
);

CREATE INDEX ON gplantel_part.colaborador_plantel_pxxx (plantel_id);
CREATE INDEX ON gplantel_part.colaborador_plantel_pxxx (colaborador_id);
CREATE INDEX ON gplantel_part.colaborador_plantel_pxxx (periodo_id);

ALTER TABLE gplantel_part.colaborador_plantel_pxxx ADD CONSTRAINT colaborador_plantel_pxxx_periodo_pk PRIMARY KEY (id);

ALTER TABLE gplantel_part.colaborador_plantel_pxxx ADD CONSTRAINT colaborador_plantel_pxxx_usuario_ini_fk1 FOREIGN KEY (usuario_ini_id)
REFERENCES seguridad.usergroups_user (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_pxxx ADD CONSTRAINT colaborador_plantel_pxxx_usuario_act_fk2 FOREIGN KEY (usuario_act_id)
REFERENCES seguridad.usergroups_user (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_pxxx ADD CONSTRAINT colaborador_plantel_pxxx_id_fk3 FOREIGN KEY (plantel_id)
REFERENCES gplantel.plantel (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_pxxx ADD CONSTRAINT colaborador_plant_colaborador_id_fk4 FOREIGN KEY (colaborador_id)
REFERENCES gplantel.colaborador (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_pxxx ADD CONSTRAINT colaborador_plantel_pxxx_periodo_id_fk5 FOREIGN KEY (periodo_id)
REFERENCES gplantel.periodo_escolar (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_pxxx ADD CONSTRAINT colaborador_plantel_pxxx_uk1 UNIQUE (colaborador_id, plantel_id, periodo_id);


CREATE TABLE gplantel_part.colaborador_plantel_asistencia_axxxx
(
    CONSTRAINT gplantel_part.colaborador_plantel_asistencia_axxxx CHECK (periodo_id = xxx)
)
INHERITS (gplantel.colaborador_plantel_asistencia)
WITH (
  OIDS = FALSE
);

CREATE INDEX ON gplantel_part.colaborador_plantel_asistencia_axxxx (plantel_id);
CREATE INDEX ON gplantel_part.colaborador_plantel_asistencia_axxxx (colaborador_id);
CREATE INDEX ON gplantel_part.colaborador_plantel_asistencia_axxxx (periodo_id);

ALTER TABLE gplantel_part.colaborador_plantel_asistencia_axxxx ADD CONSTRAINT colaborador_plantel_asistencia_axxxx_periodo_pk PRIMARY KEY (id);

ALTER TABLE gplantel_part.colaborador_plantel_asistencia_axxxx ADD CONSTRAINT colaborador_plantel_asistencia_axxxx_usuario_ini_fk1 FOREIGN KEY (usuario_ini_id)
REFERENCES seguridad.usergroups_user (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_asistencia_axxxx ADD CONSTRAINT colaborador_plantel_asistencia_axxxx_usuario_act_fk2 FOREIGN KEY (usuario_act_id)
REFERENCES seguridad.usergroups_user (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_asistencia_axxxx ADD CONSTRAINT colaborador_plantel_asistencia_axxxx_id_fk3 FOREIGN KEY (plantel_id)
REFERENCES gplantel.plantel (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_asistencia_axxxx ADD CONSTRAINT colaborador_plant_colaborador_id_fk4 FOREIGN KEY (colaborador_id)
REFERENCES gplantel.colaborador (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_asistencia_axxxx ADD CONSTRAINT colaborador_plantel_asistencia_axxxx_periodo_id_fk5 FOREIGN KEY (periodo_id)
REFERENCES gplantel.periodo_escolar (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE gplantel_part.colaborador_plantel_asistencia_axxxx ADD CONSTRAINT colaborador_plantel_asistencia_axxxx_uk1 UNIQUE (colaborador_id, plantel_id, periodo_id);
