-- Trigger: sistema_generar_codigo_ticket on sistema.ticket

-- DROP TRIGGER sistema_generar_codigo_ticket ON sistema.ticket;

CREATE TRIGGER sistema_generar_codigo_ticket
  AFTER INSERT
  ON sistema.ticket
  FOR EACH ROW
  EXECUTE PROCEDURE sistema.generar_codigo_ticket();



-- Function: sistema.generar_codigo_ticket()

-- DROP FUNCTION sistema.generar_codigo_ticket();

CREATE OR REPLACE FUNCTION sistema.generar_codigo_ticket()
  RETURNS trigger AS
$BODY$
DECLARE
    v_codigo bigint := 0;
    v_fecha_cod character varying(10) := '';
    v_consecutivo integer := 0;
BEGIN 
    IF (TG_OP = 'INSERT') THEN
        --v_fecha_cod := to_char(NEW.fecha_ini, 'YYMMDD');
        SELECT COUNT(id) INTO v_consecutivo FROM sistema.ticket t WHERE fecha_ini::date = to_char(NEW.fecha_ini, 'YYYY-MM-DD')::date;
        --v_codigo := to_number(v_fecha_cod||v_consecutivo, '99999999999999');
       update sistema.ticket set codigo=TO_CHAR(NEW.fecha_ini,'YYMMDD')||lpad(v_consecutivo::TEXT,4,'0') where id=NEW.id;
    END IF;
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sistema.generar_codigo_ticket()
  OWNER TO postgres;
