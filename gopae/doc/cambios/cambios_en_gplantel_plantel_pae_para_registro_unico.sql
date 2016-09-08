ALTER TABLE gplantel.plantel_pae
  ADD COLUMN posee_maternal character varying(2) NOT NULL DEFAULT 'NO';
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN imparte_educacion_preescolar character varying(2) NOT NULL DEFAULT 'NO';
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN imparte_educacion_primaria character varying(2) NOT NULL DEFAULT 'NO';
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN imparte_educacion_media_general character varying(2) NOT NULL DEFAULT 'NO';
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN imparte_educacion_tecnica character varying(2) NOT NULL DEFAULT 'NO';
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN imparte_educacion_especial character varying(2) NOT NULL DEFAULT 'NO';
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN posee_permiso_sanitario_vigente character varying(2) NOT NULL DEFAULT 'NO';
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN posee_proveedor_complementario character varying(2) NOT NULL DEFAULT 'NO';

ALTER TABLE gplantel.plantel_pae
  ADD COLUMN matricula_maternal smallint NOT NULL DEFAULT 0;
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN matricula_preescolar smallint NOT NULL DEFAULT 0;
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN matricula_educacion_primaria smallint NOT NULL DEFAULT 0;
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN matricula_educacion_media_general smallint NOT NULL DEFAULT 0;
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN matricula_educacion_tecnica smallint NOT NULL DEFAULT 0;
ALTER TABLE gplantel.plantel_pae
  ADD COLUMN matricula_educacion_especial smallint NOT NULL DEFAULT 0;

ALTER TABLE gplantel.plantel_pae
  ADD COLUMN proveedor_actual_id integer;

COMMENT ON COLUMN gplantel.plantel_pae.matricula_maternal IS 'Cantidad de niños de maternal que son beneficiados del PAE';
COMMENT ON COLUMN gplantel.plantel_pae.matricula_preescolar IS 'Cantidad de niños de preescolar que son beneficiados del PAE';
COMMENT ON COLUMN gplantel.plantel_pae.matricula_educacion_primaria IS 'Cantidad de estudiantes de educación primaria que son beneficiados del PAE';
COMMENT ON COLUMN gplantel.plantel_pae.matricula_educacion_media_general IS 'Cantidad de estudiantes de educación media general que son beneficiados del PAE';
COMMENT ON COLUMN gplantel.plantel_pae.matricula_educacion_tecnica IS 'Cantidad de estudiantes de educación técnica que son beneficiados del PAE';
COMMENT ON COLUMN gplantel.plantel_pae.matricula_educacion_especial IS 'Cantidad de estudiantes de educación especial que son beneficiados del PAE';

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_posee_maternal_check CHECK (posee_maternal IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_imparte_educacion_preescolar_check CHECK (imparte_educacion_preescolar IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_imparte_educacion_primaria_check CHECK (imparte_educacion_primaria IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_imparte_educacion_media_general_check CHECK (imparte_educacion_media_general IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_imparte_educacion_tecnica_check CHECK (imparte_educacion_tecnica IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_imparte_educacion_especial_check CHECK (imparte_educacion_especial IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_posee_permiso_sanitario_vigente_check CHECK (posee_permiso_sanitario_vigente IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_posee_proveedor_complementario_check CHECK (posee_proveedor_complementario IN ('SI', 'NO'));

ALTER TABLE gplantel.plantel_pae
  ADD CONSTRAINT plantel_pae_proveedor_actual_fk5 FOREIGN KEY (proveedor_actual_id) 
  REFERENCES proveduria.proveedor (id) ON UPDATE NO ACTION ON DELETE NO ACTION;

CREATE INDEX plantel_pae_proveedor_actual_indx ON gplantel.plantel_pae (proveedor_actual_id);
CREATE INDEX plantel_pae_educ_especial_indx ON gplantel.plantel_pae (imparte_educacion_especial);
CREATE INDEX plantel_pae_posee_maternal_indx ON gplantel.plantel_pae (posee_maternal);
CREATE INDEX plantel_pae_educ_preescolar_indx ON gplantel.plantel_pae (imparte_educacion_preescolar);
