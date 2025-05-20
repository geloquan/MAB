--
-- PostgreSQL database dump
--

-- Dumped from database version 9.2.24
-- Dumped by pg_dump version 9.2.24
-- Started on 2025-05-20 14:12:07

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 1 (class 3079 OID 11727)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2237 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 578 (class 1247 OID 23672)
-- Name: day_of_week_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE day_of_week_enum AS ENUM (
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
    'sunday'
);


ALTER TYPE public.day_of_week_enum OWNER TO postgres;

--
-- TOC entry 581 (class 1247 OID 23688)
-- Name: role_type_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE role_type_enum AS ENUM (
    'master',
    'secretary'
);


ALTER TYPE public.role_type_enum OWNER TO postgres;

--
-- TOC entry 584 (class 1247 OID 23694)
-- Name: specialization_type; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE specialization_type AS ENUM (
    'master',
    'sub'
);


ALTER TYPE public.specialization_type OWNER TO postgres;

--
-- TOC entry 587 (class 1247 OID 23700)
-- Name: visit_type_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE visit_type_enum AS ENUM (
    'walk-in',
    'appointment'
);


ALTER TYPE public.visit_type_enum OWNER TO postgres;

--
-- TOC entry 223 (class 1255 OID 23705)
-- Name: add_queue(integer, character varying, character varying, integer, boolean, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION add_queue(p_doctor_id integer, p_declared_full_name character varying, p_specialization_id character varying, p_declared_remarks integer, p_assisted boolean, p_assistance_note character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$

BEGIN
    INSERT INTO doctor_queue (
    	doctor_id,
    	declared_full_name, 
    	specialization_id, 
    	declared_remarks,
    	assisted,
    	assistance_note,
      	created_by
    )
    VALUES (
		p_doctor_id,
		p_declared_full_name, 
		p_specialization_id, 
		p_declared_remarks,
		p_assisted,
		p_assistance_note,
	    NOW()
    );
    
END;
$$;


ALTER FUNCTION public.add_queue(p_doctor_id integer, p_declared_full_name character varying, p_specialization_id character varying, p_declared_remarks integer, p_assisted boolean, p_assistance_note character varying) OWNER TO postgres;

--
-- TOC entry 224 (class 1255 OID 23706)
-- Name: admin_delete_advertisement_schedule(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_advertisement_schedule(p_advertisement_schedule_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE advertisement_schedule
    SET is_deleted = TRUE
    WHERE id = p_advertisement_schedule_id;
END;
$$;


ALTER FUNCTION public.admin_delete_advertisement_schedule(p_advertisement_schedule_id integer) OWNER TO postgres;

--
-- TOC entry 225 (class 1255 OID 23707)
-- Name: admin_delete_doctor(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_doctor(p_doctor_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE doctor
    SET is_deleted = TRUE
    WHERE id = p_doctor_id;
END;
$$;


ALTER FUNCTION public.admin_delete_doctor(p_doctor_id integer) OWNER TO postgres;

--
-- TOC entry 226 (class 1255 OID 23708)
-- Name: admin_delete_doctor_all_schedule(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_doctor_all_schedule(p_doctor_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE doctor_schedule
    SET is_deleted = TRUE
    WHERE doctor_id = p_doctor_id;

    UPDATE doctor
    SET updated_at = NOW()
    WHERE id = p_doctor_id;
    
END;
$$;


ALTER FUNCTION public.admin_delete_doctor_all_schedule(p_doctor_id integer) OWNER TO postgres;

--
-- TOC entry 227 (class 1255 OID 23709)
-- Name: admin_delete_doctor_all_schedule_busy(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_doctor_all_schedule_busy(p_doctor_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE doctor_busy_schedule
    SET is_deleted = TRUE
    WHERE doctor_id = p_doctor_id;

    UPDATE doctor
    SET updated_at = NOW()
    WHERE id = p_doctor_id;
    
END;
$$;


ALTER FUNCTION public.admin_delete_doctor_all_schedule_busy(p_doctor_id integer) OWNER TO postgres;

--
-- TOC entry 228 (class 1255 OID 23710)
-- Name: admin_delete_doctor_schedule(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_doctor_schedule(p_doctor_schedule_id integer, p_doctor_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE doctor_schedule
    SET is_deleted = TRUE
    WHERE id = p_doctor_schedule_id;

    UPDATE doctor
    SET updated_at = NOW()
    WHERE id = p_doctor_id;
    
END;
$$;


ALTER FUNCTION public.admin_delete_doctor_schedule(p_doctor_schedule_id integer, p_doctor_id integer) OWNER TO postgres;

--
-- TOC entry 229 (class 1255 OID 23711)
-- Name: admin_delete_hmo(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_hmo(p_hmo_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE hmo
    SET is_deleted = TRUE
    WHERE id = p_hmo_id;
END;
$$;


ALTER FUNCTION public.admin_delete_hmo(p_hmo_id integer) OWNER TO postgres;

--
-- TOC entry 230 (class 1255 OID 23712)
-- Name: admin_delete_specialization(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_specialization(p_specialization_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE specialization
    SET is_deleted = TRUE
    WHERE id = p_specialization_id;
END;
$$;


ALTER FUNCTION public.admin_delete_specialization(p_specialization_id integer) OWNER TO postgres;

--
-- TOC entry 231 (class 1255 OID 23713)
-- Name: admin_delete_user(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_delete_user(p_user_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE users
    SET is_deleted = TRUE
    WHERE id = p_user_id;
END;
$$;


ALTER FUNCTION public.admin_delete_user(p_user_id integer) OWNER TO postgres;

--
-- TOC entry 232 (class 1255 OID 23714)
-- Name: admin_insert_advertisement_schedule(character varying, smallint, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_insert_advertisement_schedule(p_name character varying, p_is_active smallint, p_large_image_path character varying, p_medium_image_path character varying, p_start_datetime character varying, p_end_datetime character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
  INSERT INTO advertisement_schedule (
    name,
    is_active,
    large_image_path,
    medium_image_path,
    start_datetime,
    end_datetime,
    updated_at
  ) VALUES (
    p_name,
    p_is_active,
    p_large_image_path,
    p_medium_image_path,
    p_start_datetime::timestamp without time zone,
    p_end_datetime::timestamp without time zone,
    NOW()
  );
END;
$$;


ALTER FUNCTION public.admin_insert_advertisement_schedule(p_name character varying, p_is_active smallint, p_large_image_path character varying, p_medium_image_path character varying, p_start_datetime character varying, p_end_datetime character varying) OWNER TO postgres;

--
-- TOC entry 233 (class 1255 OID 23715)
-- Name: admin_insert_doctor(character varying, character varying, character varying, character, character varying, character varying, character varying, smallint, character varying, integer[], integer, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_insert_doctor(p_first_name character varying, p_last_name character varying, p_date_of_birth character varying, p_suffix character DEFAULT NULL::bpchar, p_middle_name character varying DEFAULT NULL::character varying, p_contact_number character varying DEFAULT NULL::character varying, p_clinic_code_name character varying DEFAULT NULL::character varying, p_is_active smallint DEFAULT 1, p_image_path character varying DEFAULT NULL::character varying, p_hmo_id_array integer[] DEFAULT '{}'::integer[], p_master_specialization_id integer DEFAULT NULL::integer, p_sub_specialization_array integer[] DEFAULT '{}'::integer[]) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_doctor_id integer;
    hmo_id_record integer;
    sub_specialization_id integer;
BEGIN
    INSERT INTO doctor (
        first_name,
        last_name,
        date_of_birth,
        suffix,
        middle_name,
        is_active,
        image_path,
        contact_number,
        created_at,
        updated_at
    )
    VALUES (
        p_first_name,
        p_last_name,
        NULLIF(p_date_of_birth, '')::timestamp,
        p_suffix,
        p_middle_name,
        p_is_active,
        p_image_path,
        p_contact_number,
        NOW(),
        NOW()
    )
    RETURNING id INTO new_doctor_id;
    
    IF p_clinic_code_name IS NOT NULL THEN
        INSERT INTO doctor_clinic (
            code_name,
            doctor_id,
            created_at,
            updated_at
        ) VALUES (
            p_clinic_code_name,
            new_doctor_id, 
            NOW(),
            NOW()
        );
    END IF;
    
    IF p_master_specialization_id IS NOT NULL 
    AND p_master_specialization_id != 0
    THEN
        INSERT INTO doctor_specialization (
            doctor_id,
            specialization_id,
            created_at,
            updated_at
        ) VALUES (
            new_doctor_id,
            p_master_specialization_id,
            NOW(),
            NOW()
        );
    END IF;

    IF p_sub_specialization_array  IS NOT NULL THEN
      FOREACH sub_specialization_id IN ARRAY p_sub_specialization_array
      LOOP
        INSERT INTO doctor_specialization (
          doctor_id,
          specialization_id,
          created_at,
          updated_at
        ) VALUES (
          new_doctor_id,
          sub_specialization_id,
          NOW(),
          NOW()
        );
      END LOOP;
    END IF;
    
    IF p_hmo_id_array IS NOT NULL THEN
      FOREACH hmo_id_record IN ARRAY p_hmo_id_array
      LOOP
          INSERT INTO doctor_hmo (
              doctor_id,
              hmo_id,
              is_active,
              created_at,
              updated_at
          ) VALUES (
              new_doctor_id,
              hmo_id_record,
              1,
              NOW(),
              NOW()
          );
      END LOOP;
    END IF;

    RETURN new_doctor_id;
END;
$$;


ALTER FUNCTION public.admin_insert_doctor(p_first_name character varying, p_last_name character varying, p_date_of_birth character varying, p_suffix character, p_middle_name character varying, p_contact_number character varying, p_clinic_code_name character varying, p_is_active smallint, p_image_path character varying, p_hmo_id_array integer[], p_master_specialization_id integer, p_sub_specialization_array integer[]) OWNER TO postgres;

--
-- TOC entry 234 (class 1255 OID 23716)
-- Name: admin_insert_doctor_schedule(integer, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_insert_doctor_schedule(p_doctor_id integer, p_start_time character varying, p_end_time character varying, p_visit_type character varying, p_day_of_week character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
  day_list text[];
  single_day text;
BEGIN
  IF p_day_of_week = 'weekdays' THEN
    day_list := ARRAY['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
  ELSIF p_day_of_week = 'weekends' THEN
    day_list := ARRAY['saturday', 'sunday'];
  ELSIF p_day_of_week = 'everyday' THEN
    day_list := ARRAY['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
  ELSE
    day_list := ARRAY[p_day_of_week];
  END IF;
    
  FOREACH single_day IN ARRAY day_list LOOP
    INSERT INTO doctor_schedule (
      doctor_id,
      start_time,
      end_time,
      day_of_week,
      visit_type,
      created_at,
      updated_at
    ) VALUES (
      p_doctor_id,
      p_start_time::time without time zone,
      p_end_time::time without time zone,
      single_day::day_of_week_enum,
      p_visit_type::visit_type_enum,
      now(),
      now()
    );
  END LOOP;
END;
$$;


ALTER FUNCTION public.admin_insert_doctor_schedule(p_doctor_id integer, p_start_time character varying, p_end_time character varying, p_visit_type character varying, p_day_of_week character varying) OWNER TO postgres;

--
-- TOC entry 235 (class 1255 OID 23717)
-- Name: admin_insert_doctor_schedule_busy(integer, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_insert_doctor_schedule_busy(p_doctor_id integer, p_datetime_start character varying, p_datetime_end character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO doctor_busy_schedule (
        doctor_id,
        start_datetime,
        end_datetime,
        created_at
    ) VALUES (
        p_doctor_id,
        p_datetime_start::timestamp without time zone,
        p_datetime_end::timestamp without time zone,
        NOW()
    );
END;
$$;


ALTER FUNCTION public.admin_insert_doctor_schedule_busy(p_doctor_id integer, p_datetime_start character varying, p_datetime_end character varying) OWNER TO postgres;

--
-- TOC entry 236 (class 1255 OID 23718)
-- Name: admin_insert_hmo(character varying, character varying, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_insert_hmo(p_name character varying, p_description character varying, p_is_active smallint DEFAULT 1) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_hmo_id integer;
BEGIN
    INSERT INTO hmo (
        name,
        description,
        is_active,
        created_at,
        updated_at
    )
    VALUES (
        UPPER(p_name),
        p_description,
        p_is_active,
        NOW(),
        NOW()
    )
    RETURNING id INTO new_hmo_id;
    
    RETURN new_hmo_id;
END;
$$;


ALTER FUNCTION public.admin_insert_hmo(p_name character varying, p_description character varying, p_is_active smallint) OWNER TO postgres;

--
-- TOC entry 237 (class 1255 OID 23719)
-- Name: admin_insert_specialization(character varying, character varying, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_insert_specialization(p_name character varying, p_type character varying, p_is_active smallint DEFAULT 1) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_specialization_id integer;
BEGIN
    INSERT INTO specialization (name, type, is_active, created_at, updated_at)
    VALUES (UPPER(p_name), p_type::specialization_type, p_is_active, NOW(), NOW())
    RETURNING id INTO new_specialization_id;
    
    RETURN new_specialization_id;
END;
$$;


ALTER FUNCTION public.admin_insert_specialization(p_name character varying, p_type character varying, p_is_active smallint) OWNER TO postgres;

--
-- TOC entry 238 (class 1255 OID 23720)
-- Name: admin_insert_user(character varying, character varying, character varying, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_insert_user(p_username character varying, p_email character varying, p_role_type character varying, p_disabled smallint DEFAULT 0) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_user_id integer;
BEGIN
    INSERT INTO users (
        username,
        email,
		role_type,
        is_disabled,
        created_at,
        updated_at
    )
    VALUES (
        p_username,
        p_email,
        p_role_type::role_type_enum,
		p_disabled,
        NOW(),
        NOW()
    )
    RETURNING id INTO new_user_id;
    
    RETURN new_user_id;
END;
$$;


ALTER FUNCTION public.admin_insert_user(p_username character varying, p_email character varying, p_role_type character varying, p_disabled smallint) OWNER TO postgres;

--
-- TOC entry 239 (class 1255 OID 23721)
-- Name: admin_update_advertisement_schedule(integer, character varying, smallint, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_update_advertisement_schedule(p_advertisement_schedule_id integer, p_name character varying DEFAULT NULL::character varying, p_is_active smallint DEFAULT 0, p_large_image_path character varying DEFAULT NULL::character varying, p_medium_image_path character varying DEFAULT NULL::character varying, p_start_datetime character varying DEFAULT NULL::character varying, p_end_datetime character varying DEFAULT NULL::character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE advertisement_schedule
    SET 
        name = COALESCE(p_name, name),
        is_active = p_is_active,
        large_image_path = COALESCE(p_large_image_path, large_image_path),
        medium_image_path = COALESCE(p_medium_image_path, medium_image_path),
        start_datetime = COALESCE(p_start_datetime::timestamp without time zone, start_datetime),
        end_datetime = COALESCE(p_end_datetime::timestamp without time zone, end_datetime),
        updated_at = NOW()
    WHERE id = p_advertisement_schedule_id;
END;
$$;


ALTER FUNCTION public.admin_update_advertisement_schedule(p_advertisement_schedule_id integer, p_name character varying, p_is_active smallint, p_large_image_path character varying, p_medium_image_path character varying, p_start_datetime character varying, p_end_datetime character varying) OWNER TO postgres;

--
-- TOC entry 240 (class 1255 OID 23722)
-- Name: admin_update_doctor(integer, character varying, character varying, character varying, character, character varying, smallint, integer, character varying, character varying, character varying, integer[], integer, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_update_doctor(p_doctor_id integer, p_first_name character varying, p_last_name character varying, p_date_of_birth character varying, p_suffix character, p_middle_name character varying, p_is_active smallint DEFAULT 1, p_dc_id integer DEFAULT NULL::integer, p_contact_number character varying DEFAULT NULL::character varying, p_clinic_code_name character varying DEFAULT NULL::character varying, p_image_path character varying DEFAULT NULL::character varying, p_hmo_id_array integer[] DEFAULT '{}'::integer[], p_master_specialization_id integer DEFAULT NULL::integer, p_sub_specialization_array integer[] DEFAULT '{}'::integer[]) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
hmo_id integer;
  sub_specialization_id integer;
BEGIN
  -- Handle doctor_clinic update or insert
  IF p_dc_id IS NOT NULL AND p_clinic_code_name IS NOT NULL THEN 
    IF EXISTS (SELECT 1 FROM doctor_clinic WHERE doctor_id = p_doctor_id) THEN 
      UPDATE doctor_clinic 
      SET code_name = p_clinic_code_name 
      WHERE doctor_id = p_doctor_id; 
    ELSE 
      INSERT INTO doctor_clinic (doctor_id, code_name) 
      VALUES (p_doctor_id, p_clinic_code_name); 
    END IF; 
  END IF;
    
  -- Update doctor information
  IF p_image_path IS NOT NULL THEN
    UPDATE doctor
    SET first_name = p_first_name,
        last_name = p_last_name,
        date_of_birth = NULLIF(p_date_of_birth, '')::timestamp,
        suffix = p_suffix,
        middle_name = p_middle_name,
        is_active = p_is_active,
        contact_number = p_contact_number,
        image_path = p_image_path,
        updated_at = NOW()
    WHERE id = p_doctor_id;
  ELSE
    UPDATE doctor
    SET first_name = p_first_name,
        last_name = p_last_name,
        date_of_birth = NULLIF(p_date_of_birth, '')::timestamp,
        suffix = p_suffix,
        middle_name = p_middle_name,
        is_active = p_is_active,
        contact_number = p_contact_number,
        updated_at = NOW()
    WHERE id = p_doctor_id;
  END IF;
  
  -- Delete non-master specializations
  DELETE FROM doctor_specialization 
  WHERE doctor_id = p_doctor_id 
  AND specialization_id IN (
    SELECT ds.specialization_id 
    FROM doctor_specialization ds
    JOIN specialization s ON ds.specialization_id = s.id
    WHERE ds.doctor_id = p_doctor_id AND s.type != 'master'
  );
  
  -- Delete doctor_hmo records
  DELETE FROM doctor_hmo
  WHERE doctor_id = p_doctor_id;
  
  -- Update master specialization if provided
  IF p_master_specialization_id IS NOT NULL 
  AND p_master_specialization_id != 0
  THEN
    UPDATE doctor_specialization ds
    SET specialization_id = p_master_specialization_id
    FROM specialization s
    WHERE ds.doctor_id = p_doctor_id 
    AND ds.specialization_id = s.id 
    AND s.type = 'master';
    
    -- If no master specialization exists, insert it
    IF NOT FOUND THEN
      INSERT INTO doctor_specialization (
        doctor_id,
        specialization_id,
        created_at,
        updated_at
      ) VALUES (
        p_doctor_id,
        p_master_specialization_id,
        NOW(),
        NOW()
      );
    END IF;
  END IF;
  
  -- Insert sub-specializations
    IF p_sub_specialization_array  IS NOT NULL THEN
      FOREACH sub_specialization_id IN ARRAY p_sub_specialization_array
      LOOP
        INSERT INTO doctor_specialization (
          doctor_id,
          specialization_id,
          created_at,
          updated_at
        ) VALUES (
          p_doctor_id,
          sub_specialization_id,
          NOW(),
          NOW()
        );
      END LOOP;
    END IF;
  
  -- Insert HMO relationships
  IF p_hmo_id_array IS NOT NULL THEN
    FOREACH hmo_id IN ARRAY p_hmo_id_array
    LOOP
      INSERT INTO doctor_hmo (
        doctor_id,
        hmo_id,
        created_at,
        updated_at
      ) VALUES (
        p_doctor_id,
        hmo_id,
        NOW(),
        NOW()
      );
    END LOOP;
  END IF;
END;
$$;


ALTER FUNCTION public.admin_update_doctor(p_doctor_id integer, p_first_name character varying, p_last_name character varying, p_date_of_birth character varying, p_suffix character, p_middle_name character varying, p_is_active smallint, p_dc_id integer, p_contact_number character varying, p_clinic_code_name character varying, p_image_path character varying, p_hmo_id_array integer[], p_master_specialization_id integer, p_sub_specialization_array integer[]) OWNER TO postgres;

--
-- TOC entry 241 (class 1255 OID 23723)
-- Name: admin_update_doctor_schedule(integer, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_update_doctor_schedule(p_doctor_schedule_id integer, p_start_time character varying, p_end_time character varying, p_dow character varying, p_visit_type character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
  UPDATE doctor_schedule 
  SET start_time = p_start_time::time without time zone,
  end_time = p_end_time::time without time zone,
  day_of_week = p_dow::day_of_week_enum,
  visit_type = p_visit_type::visit_type_enum
  WHERE id = p_doctor_schedule_id;

END;
$$;


ALTER FUNCTION public.admin_update_doctor_schedule(p_doctor_schedule_id integer, p_start_time character varying, p_end_time character varying, p_dow character varying, p_visit_type character varying) OWNER TO postgres;

--
-- TOC entry 242 (class 1255 OID 23724)
-- Name: admin_update_hmo(integer, character varying, character varying, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_update_hmo(p_hmo_id integer, p_name character varying, p_description character varying, p_is_active smallint DEFAULT 1) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE hmo
    SET name = p_name,
        description = p_description,
        is_active = p_is_active,
        updated_at = NOW()
    WHERE id = p_hmo_id;
END;
$$;


ALTER FUNCTION public.admin_update_hmo(p_hmo_id integer, p_name character varying, p_description character varying, p_is_active smallint) OWNER TO postgres;

--
-- TOC entry 243 (class 1255 OID 23725)
-- Name: admin_update_specialization(integer, character varying, character varying, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_update_specialization(p_specialization_id integer, p_name character varying, p_type character varying, p_is_active smallint DEFAULT 1) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE specialization
    SET name = UPPER(p_name),
        type = p_type::specialization_type, -- Cast to the enum type
        is_active = p_is_active,
        updated_at = NOW()
    WHERE id = p_specialization_id;
END;
$$;


ALTER FUNCTION public.admin_update_specialization(p_specialization_id integer, p_name character varying, p_type character varying, p_is_active smallint) OWNER TO postgres;

--
-- TOC entry 244 (class 1255 OID 23726)
-- Name: admin_update_user(integer, character varying, character varying, character varying, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION admin_update_user(p_user_id integer, p_username character varying, p_email character varying, p_role_type character varying, p_is_disabled smallint) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE users
    SET username = p_username,
        email = p_email,
        is_disabled = p_is_disabled,
		role_type = p_role_type::role_type_enum,
        updated_at = NOW()
    WHERE id = p_user_id;
END;
$$;


ALTER FUNCTION public.admin_update_user(p_user_id integer, p_username character varying, p_email character varying, p_role_type character varying, p_is_disabled smallint) OWNER TO postgres;

--
-- TOC entry 245 (class 1255 OID 23727)
-- Name: availability_stats(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION availability_stats(p_hmo character varying DEFAULT NULL::character varying, p_specialization character varying DEFAULT NULL::character varying) RETURNS json
    LANGUAGE plpgsql
    AS $$
DECLARE
    result json;
BEGIN
    SELECT row_to_json(row) INTO result
    FROM (
        WITH time_categorized_schedules AS (
            SELECT 
                ds.doctor_id,
                ds.day_of_week,
                CASE WHEN (
                    (ds.start_time < '10:59:00' AND ds.end_time > '04:00:00') OR -- Morning (4AM-11AM)
                    (ds.start_time < '04:00:00' AND ds.end_time > '04:00:00')
                ) THEN 1 ELSE NULL END AS is_morning,
                CASE WHEN (
                    (ds.start_time < '12:59:00' AND ds.end_time > '11:00:00') -- Noon (11AM-1PM)
                ) THEN 1 ELSE NULL END AS is_noon,
                CASE WHEN (
                    (ds.start_time < '16:59:00' AND ds.end_time > '13:00:00') -- Afternoon (1PM-5PM)
                ) THEN 1 ELSE NULL END AS is_afternoon,
                CASE WHEN (
                    (ds.end_time > '16:59:00' OR ds.start_time < '04:00:00') AND -- Evening (5PM-4AM)
                    (ds.start_time < '04:00:00' OR ds.end_time > '16:59:00')
                ) THEN 1 ELSE NULL END AS is_evening
            FROM doctor d
            LEFT JOIN doctor_schedule ds ON d.id = ds.doctor_id AND ds.is_deleted = false
            LEFT JOIN doctor_specialization dsp ON d.id = dsp.doctor_id
            LEFT JOIN doctor_hmo dh ON d.id = dh.doctor_id
            
            LEFT JOIN hmo h ON dh.hmo_id = h.id AND 
                                        h.is_deleted = false AND
                                     (p_hmo IS NULL OR UPPER(h.name) = UPPER(p_hmo))
                                     
            LEFT JOIN specialization s ON dsp.specialization_id = s.id AND 
                                        s.is_deleted = false AND
                                        (p_specialization IS NULL OR UPPER(s.name) = UPPER(p_specialization))
            WHERE d.is_deleted = false
            AND d.is_active = 1
            AND (p_specialization IS NULL OR s.id IS NOT NULL)
            AND (p_hmo IS NULL OR h.id IS NOT NULL)
        )
        SELECT 
            COUNT(DISTINCT CASE WHEN day_of_week = 'monday' THEN doctor_id END)::BIGINT AS "Monday",
            COUNT(DISTINCT CASE WHEN day_of_week = 'tuesday' THEN doctor_id END)::BIGINT AS "Tuesday",
            COUNT(DISTINCT CASE WHEN day_of_week = 'wednesday' THEN doctor_id END)::BIGINT AS "Wednesday",
            COUNT(DISTINCT CASE WHEN day_of_week = 'thursday' THEN doctor_id END)::BIGINT AS "Thursday",
            COUNT(DISTINCT CASE WHEN day_of_week = 'friday' THEN doctor_id END)::BIGINT AS "Friday",
            COUNT(DISTINCT CASE WHEN day_of_week = 'saturday' THEN doctor_id END)::BIGINT AS "Saturday",
            COUNT(DISTINCT CASE WHEN day_of_week = 'sunday' THEN doctor_id END)::BIGINT AS "Sunday",
            COUNT(DISTINCT CASE WHEN is_morning = 1 THEN doctor_id END)::BIGINT AS "Morning",
            COUNT(DISTINCT CASE WHEN is_noon = 1 THEN doctor_id END)::BIGINT AS "Noon",
            COUNT(DISTINCT CASE WHEN is_afternoon = 1 THEN doctor_id END)::BIGINT AS "Afternoon",
            COUNT(DISTINCT CASE WHEN is_evening = 1 THEN doctor_id END)::BIGINT AS "Evening"
        FROM time_categorized_schedules
    ) row;
    
    RETURN result;
END;
$$;


ALTER FUNCTION public.availability_stats(p_hmo character varying, p_specialization character varying) OWNER TO postgres;

--
-- TOC entry 246 (class 1255 OID 23728)
-- Name: is_master_specialization(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION is_master_specialization(spec_id integer) RETURNS boolean
    LANGUAGE plpgsql IMMUTABLE
    AS $$
BEGIN
  RETURN EXISTS (SELECT 1 FROM specialization WHERE id = spec_id AND type = 'master');
END;
$$;


ALTER FUNCTION public.is_master_specialization(spec_id integer) OWNER TO postgres;

--
-- TOC entry 247 (class 1255 OID 23729)
-- Name: login(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION login(p_username character varying, p_password character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN (
        SELECT id
        FROM users 
        WHERE username = p_username 
        AND password = p_password
        AND is_deleted = FALSE
        AND is_disabled = 0
        LIMIT 1
    );
END;
$$;


ALTER FUNCTION public.login(p_username character varying, p_password character varying) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 169 (class 1259 OID 23730)
-- Name: advertisement_schedule; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE advertisement_schedule (
    id integer NOT NULL,
    large_image_path text,
    medium_image_path text,
    start_datetime timestamp without time zone,
    end_datetime timestamp without time zone,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    is_deleted boolean DEFAULT false,
    is_active smallint DEFAULT 1,
    name character varying(155)
);


ALTER TABLE public.advertisement_schedule OWNER TO postgres;

--
-- TOC entry 170 (class 1259 OID 23740)
-- Name: admin_advertisement_schedule; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW admin_advertisement_schedule AS
    SELECT adsch.id, adsch.name, adsch.is_active, adsch.large_image_path, adsch.medium_image_path, adsch.start_datetime, adsch.end_datetime, adsch.created_at, adsch.updated_at, adsch.is_deleted, CASE WHEN (adsch.is_active = 0) THEN 'Offline'::text WHEN (((now() + '08:00:00'::interval) >= adsch.start_datetime) AND ((now() + '08:00:00'::interval) <= adsch.end_datetime)) THEN 'Live'::text ELSE 'In-queue'::text END AS status FROM advertisement_schedule adsch WHERE ((adsch.is_deleted = false) AND ((adsch.end_datetime IS NULL) OR (adsch.end_datetime >= now())));


ALTER TABLE public.admin_advertisement_schedule OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 23744)
-- Name: doctor; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor (
    id integer NOT NULL,
    first_name character varying(255),
    last_name character varying(255),
    middle_name character varying(255),
    suffix character(10),
    date_of_birth timestamp without time zone,
    image bytea,
    is_active smallint,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    image_path text,
    contact_number character varying(45),
    is_deleted boolean DEFAULT false
);


ALTER TABLE public.doctor OWNER TO postgres;

--
-- TOC entry 172 (class 1259 OID 23753)
-- Name: doctor_busy_schedule; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_busy_schedule (
    id integer NOT NULL,
    doctor_id integer,
    start_datetime timestamp without time zone,
    end_datetime timestamp without time zone,
    is_deleted boolean DEFAULT false,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval)
);


ALTER TABLE public.doctor_busy_schedule OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 23759)
-- Name: doctor_clinic; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_clinic (
    id integer NOT NULL,
    code_name character varying(55),
    doctor_id integer,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval)
);


ALTER TABLE public.doctor_clinic OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 23764)
-- Name: doctor_hmo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_hmo (
    id integer NOT NULL,
    doctor_id integer,
    hmo_id integer,
    is_active smallint,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval)
);


ALTER TABLE public.doctor_hmo OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 23769)
-- Name: doctor_schedule; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_schedule (
    id integer NOT NULL,
    doctor_id integer,
    start_time time without time zone NOT NULL,
    end_time time without time zone NOT NULL,
    day_of_week day_of_week_enum,
    visit_type visit_type_enum,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    is_deleted boolean DEFAULT false
);


ALTER TABLE public.doctor_schedule OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 23775)
-- Name: doctor_specialization; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_specialization (
    id integer NOT NULL,
    doctor_id integer NOT NULL,
    specialization_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval)
);


ALTER TABLE public.doctor_specialization OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 23780)
-- Name: hmo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hmo (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255),
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    is_active smallint NOT NULL,
    is_deleted boolean DEFAULT false
);


ALTER TABLE public.hmo OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 23789)
-- Name: specialization; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE specialization (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    type specialization_type NOT NULL,
    is_active smallint NOT NULL,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    is_deleted boolean DEFAULT false
);


ALTER TABLE public.specialization OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 23795)
-- Name: admin_doctor; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW admin_doctor AS
    SELECT d.id, d.first_name, d.last_name, d.middle_name, d.suffix, (d.date_of_birth)::date AS date_of_birth, d.image, d.is_active, d.created_at, d.updated_at, d.image_path, d.contact_number, d.is_deleted, dc.id AS dc_id, dc.code_name AS dc_code_name, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT s_inner.id, s_inner.name, s_inner.type FROM (doctor_specialization dsp_inner LEFT JOIN specialization s_inner ON ((dsp_inner.specialization_id = s_inner.id))) WHERE (((dsp_inner.doctor_id = d.id) AND (s_inner.is_active = 1)) AND (s_inner.is_deleted = false))) specs), '[]'::json) AS specializations, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT ds_inner.id, ds_inner.start_time, ds_inner.end_time, ds_inner.day_of_week, ds_inner.visit_type FROM doctor_schedule ds_inner WHERE ((ds_inner.doctor_id = d.id) AND (ds_inner.is_deleted = false))) specs), '[]'::json) AS schedule, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT dbs_inner.id, dbs_inner.start_datetime, dbs_inner.end_datetime FROM doctor_busy_schedule dbs_inner WHERE (((dbs_inner.doctor_id = d.id) AND (dbs_inner.is_deleted = false)) AND ((timezone('UTC'::text, now()) + '08:00:00'::interval) <= dbs_inner.end_datetime))) specs), '[]'::json) AS schedule_busy, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT DISTINCT h_inner.id, h_inner.name FROM (doctor_hmo dh_inner LEFT JOIN hmo h_inner ON ((dh_inner.hmo_id = h_inner.id))) WHERE (dh_inner.doctor_id = d.id) ORDER BY h_inner.name) specs), '[]'::json) AS hmos FROM ((((((((doctor d LEFT JOIN doctor_clinic dc ON ((d.id = dc.doctor_id))) LEFT JOIN doctor_specialization ds ON ((d.id = ds.doctor_id))) LEFT JOIN doctor_schedule dsc ON ((d.id = dsc.doctor_id))) LEFT JOIN doctor_hmo dh ON ((d.id = dh.doctor_id))) LEFT JOIN hmo h ON ((dh.hmo_id = h.id))) LEFT JOIN specialization s ON ((ds.specialization_id = s.id))) LEFT JOIN specialization s_master ON (((ds.specialization_id = s_master.id) AND (s.type = 'master'::specialization_type)))) LEFT JOIN specialization s_sub ON (((ds.specialization_id = s_sub.id) AND (s.type = 'sub'::specialization_type)))) WHERE (d.is_deleted IS FALSE) GROUP BY d.id, d.first_name, d.last_name, d.middle_name, d.suffix, d.date_of_birth, d.image, d.is_active, d.created_at, d.updated_at, d.image_path, d.contact_number, d.is_deleted, dc.id, dc.code_name ORDER BY d.last_name;


ALTER TABLE public.admin_doctor OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 23800)
-- Name: doctor_user_assign; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_user_assign (
    id integer NOT NULL,
    doctor_id integer,
    user_id integer
);


ALTER TABLE public.doctor_user_assign OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 23803)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    email character varying(255),
    password character varying(255),
    remember_token character varying(100),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    role_type role_type_enum DEFAULT 'secretary'::role_type_enum NOT NULL,
    is_disabled smallint DEFAULT 0,
    is_deleted boolean DEFAULT false,
    last_password_changed timestamp without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 23814)
-- Name: admin_doctor_user; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW admin_doctor_user AS
    SELECT u.id, u.username, u.email, u.created_at, u.updated_at, u.role_type, u.last_password_changed, u.is_disabled, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT d_inner.id, d_inner.first_name, d_inner.last_name FROM (doctor_user_assign dua_inner LEFT JOIN doctor d_inner ON ((dua_inner.doctor_id = d_inner.id))) WHERE (dua_inner.user_id = u.id)) specs), '[]'::json) AS assigned_doctors FROM users u WHERE (u.is_deleted = false);


ALTER TABLE public.admin_doctor_user OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 23819)
-- Name: admin_hmo; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW admin_hmo AS
    SELECT h.id, h.name, h.description, h.created_at, h.updated_at, h.is_active, h.is_deleted FROM hmo h WHERE (h.is_deleted = false);


ALTER TABLE public.admin_hmo OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 23823)
-- Name: admin_specialization; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW admin_specialization AS
    SELECT specialization.id, specialization.name, (specialization.type)::text AS type, specialization.created_at, specialization.updated_at, specialization.is_active FROM specialization WHERE (specialization.is_deleted = false) ORDER BY specialization.name;


ALTER TABLE public.admin_specialization OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 23827)
-- Name: advertisement_schedule_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE advertisement_schedule_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.advertisement_schedule_id_seq OWNER TO postgres;

--
-- TOC entry 2238 (class 0 OID 0)
-- Dependencies: 185
-- Name: advertisement_schedule_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE advertisement_schedule_id_seq OWNED BY advertisement_schedule.id;


--
-- TOC entry 186 (class 1259 OID 23829)
-- Name: available_hmo; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW available_hmo AS
    SELECT DISTINCT h.name FROM ((hmo h LEFT JOIN doctor_hmo dh ON ((dh.hmo_id = h.id))) LEFT JOIN doctor d ON ((dh.doctor_id = d.id))) WHERE ((((d.is_active = 1) AND (d.is_deleted = false)) AND (h.is_active = 1)) AND (h.is_deleted = false)) ORDER BY h.name;


ALTER TABLE public.available_hmo OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 23834)
-- Name: available_schedule_count; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW available_schedule_count AS
    WITH time_categorized_schedules AS (SELECT ds.doctor_id, ds.day_of_week, CASE WHEN (((ds.start_time < '10:59:00'::time without time zone) AND (ds.end_time > '04:00:00'::time without time zone)) OR ((ds.start_time < '04:00:00'::time without time zone) AND (ds.end_time > '04:00:00'::time without time zone))) THEN 1 ELSE NULL::integer END AS is_morning, CASE WHEN ((ds.start_time < '12:59:00'::time without time zone) AND (ds.end_time > '11:00:00'::time without time zone)) THEN 1 ELSE NULL::integer END AS is_noon, CASE WHEN ((ds.start_time < '16:59:00'::time without time zone) AND (ds.end_time > '13:00:00'::time without time zone)) THEN 1 ELSE NULL::integer END AS is_afternoon, CASE WHEN (((ds.end_time > '16:59:00'::time without time zone) OR (ds.start_time < '04:00:00'::time without time zone)) AND ((ds.start_time < '04:00:00'::time without time zone) OR (ds.end_time > '16:59:00'::time without time zone))) THEN 1 ELSE NULL::integer END AS is_evening FROM (doctor d LEFT JOIN doctor_schedule ds ON ((d.id = ds.doctor_id))) WHERE (((d.is_deleted = false) AND (ds.is_deleted = false)) AND (d.is_active = 1))) SELECT count(DISTINCT CASE WHEN (time_categorized_schedules.day_of_week = 'monday'::day_of_week_enum) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS monday, count(DISTINCT CASE WHEN (time_categorized_schedules.day_of_week = 'tuesday'::day_of_week_enum) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS tuesday, count(DISTINCT CASE WHEN (time_categorized_schedules.day_of_week = 'wednesday'::day_of_week_enum) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS wednesday, count(DISTINCT CASE WHEN (time_categorized_schedules.day_of_week = 'thursday'::day_of_week_enum) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS thursday, count(DISTINCT CASE WHEN (time_categorized_schedules.day_of_week = 'friday'::day_of_week_enum) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS friday, count(DISTINCT CASE WHEN (time_categorized_schedules.day_of_week = 'saturday'::day_of_week_enum) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS saturday, count(DISTINCT CASE WHEN (time_categorized_schedules.day_of_week = 'sunday'::day_of_week_enum) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS sunday, count(DISTINCT CASE WHEN (time_categorized_schedules.is_morning = 1) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS morning, count(DISTINCT CASE WHEN (time_categorized_schedules.is_noon = 1) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS noon, count(DISTINCT CASE WHEN (time_categorized_schedules.is_afternoon = 1) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS afternoon, count(DISTINCT CASE WHEN (time_categorized_schedules.is_evening = 1) THEN time_categorized_schedules.doctor_id ELSE NULL::integer END) AS evening FROM time_categorized_schedules;


ALTER TABLE public.available_schedule_count OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 23839)
-- Name: available_specialization; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW available_specialization AS
    SELECT DISTINCT sp.name FROM ((specialization sp LEFT JOIN doctor_specialization ds ON ((ds.specialization_id = sp.id))) LEFT JOIN doctor d ON ((ds.doctor_id = d.id))) WHERE ((((d.is_active = 1) AND (d.is_deleted = false)) AND (sp.is_active = 1)) AND (sp.is_deleted = false)) ORDER BY sp.name;


ALTER TABLE public.available_specialization OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 24024)
-- Name: doctor_busy_next_7days_dow; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW doctor_busy_next_7days_dow AS
    SELECT doctor_busy_schedule.id, doctor_busy_schedule.doctor_id, CASE date_part('dow'::text, doctor_busy_schedule.start_datetime) WHEN 0 THEN 'sunday'::text WHEN 1 THEN 'monday'::text WHEN 2 THEN 'tuesday'::text WHEN 3 THEN 'wednesday'::text WHEN 4 THEN 'thursday'::text WHEN 5 THEN 'friday'::text WHEN 6 THEN 'saturday'::text ELSE NULL::text END AS day_name, (doctor_busy_schedule.start_datetime)::time without time zone AS start_time, (doctor_busy_schedule.end_datetime)::time without time zone AS end_time, doctor_busy_schedule.created_at, doctor_busy_schedule.updated_at FROM doctor_busy_schedule WHERE (((doctor_busy_schedule.start_datetime >= date_trunc('day'::text, now())) AND (doctor_busy_schedule.start_datetime < (date_trunc('day'::text, now()) + '7 days'::interval))) AND (doctor_busy_schedule.is_deleted = false));


ALTER TABLE public.doctor_busy_next_7days_dow OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 23844)
-- Name: doctor_busy_schedule_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_busy_schedule_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_busy_schedule_id_seq OWNER TO postgres;

--
-- TOC entry 2239 (class 0 OID 0)
-- Dependencies: 189
-- Name: doctor_busy_schedule_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_busy_schedule_id_seq OWNED BY doctor_busy_schedule.id;


--
-- TOC entry 190 (class 1259 OID 23846)
-- Name: doctor_clinic_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_clinic_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_clinic_id_seq OWNER TO postgres;

--
-- TOC entry 2240 (class 0 OID 0)
-- Dependencies: 190
-- Name: doctor_clinic_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_clinic_id_seq OWNED BY doctor_clinic.id;


--
-- TOC entry 191 (class 1259 OID 23848)
-- Name: doctor_hmo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_hmo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_hmo_id_seq OWNER TO postgres;

--
-- TOC entry 2241 (class 0 OID 0)
-- Dependencies: 191
-- Name: doctor_hmo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_hmo_id_seq OWNED BY doctor_hmo.id;


--
-- TOC entry 192 (class 1259 OID 23850)
-- Name: doctor_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_id_seq OWNER TO postgres;

--
-- TOC entry 2242 (class 0 OID 0)
-- Dependencies: 192
-- Name: doctor_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_id_seq OWNED BY doctor.id;


--
-- TOC entry 193 (class 1259 OID 23852)
-- Name: doctor_queue; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_queue (
    id integer NOT NULL,
    doctor_id integer NOT NULL,
    declared_full_name character varying(150) NOT NULL,
    specialization_id integer,
    declared_remarks character varying(255),
    assisted boolean DEFAULT false,
    assistance_notes character varying(255),
    created_by timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval)
);


ALTER TABLE public.doctor_queue OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 23860)
-- Name: doctor_queue_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_queue_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_queue_id_seq OWNER TO postgres;

--
-- TOC entry 2243 (class 0 OID 0)
-- Dependencies: 194
-- Name: doctor_queue_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_queue_id_seq OWNED BY doctor_queue.id;


--
-- TOC entry 195 (class 1259 OID 23862)
-- Name: doctor_resource; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE doctor_resource (
    doctor_id integer,
    first_name character varying(255),
    middle_name character varying(255),
    last_name character varying(255),
    doctor_contact_number character varying(45),
    doctor_suffix character(10),
    image_path text,
    clinic_code_name character varying(55),
    master_specialization character varying(255),
    sub_specialization json,
    day_of_week json,
    doctor_hmo json,
    schedule json,
    schedule_busy json,
    specializations json
);


ALTER TABLE public.doctor_resource OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 23868)
-- Name: doctor_schedule_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_schedule_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_schedule_id_seq OWNER TO postgres;

--
-- TOC entry 2244 (class 0 OID 0)
-- Dependencies: 196
-- Name: doctor_schedule_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_schedule_id_seq OWNED BY doctor_schedule.id;


--
-- TOC entry 197 (class 1259 OID 23870)
-- Name: doctor_specialization_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_specialization_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_specialization_id_seq OWNER TO postgres;

--
-- TOC entry 2245 (class 0 OID 0)
-- Dependencies: 197
-- Name: doctor_specialization_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_specialization_id_seq OWNED BY doctor_specialization.id;


--
-- TOC entry 198 (class 1259 OID 23872)
-- Name: doctor_user_assign_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE doctor_user_assign_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_user_assign_id_seq OWNER TO postgres;

--
-- TOC entry 2246 (class 0 OID 0)
-- Dependencies: 198
-- Name: doctor_user_assign_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE doctor_user_assign_id_seq OWNED BY doctor_user_assign.id;


--
-- TOC entry 199 (class 1259 OID 23874)
-- Name: hmo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hmo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.hmo_id_seq OWNER TO postgres;

--
-- TOC entry 2247 (class 0 OID 0)
-- Dependencies: 199
-- Name: hmo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE hmo_id_seq OWNED BY hmo.id;


--
-- TOC entry 200 (class 1259 OID 23876)
-- Name: hmo_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW hmo_view AS
    SELECT admin_hmo.id, admin_hmo.name, admin_hmo.description, admin_hmo.created_at, admin_hmo.updated_at, admin_hmo.is_active, admin_hmo.is_deleted FROM admin_hmo WHERE (admin_hmo.is_deleted = false);


ALTER TABLE public.hmo_view OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 23880)
-- Name: master_specialization_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW master_specialization_view AS
    SELECT a.id, a.name, a.type, a.created_at, a.updated_at, a.is_active FROM admin_specialization a WHERE (a.type = 'master'::text);


ALTER TABLE public.master_specialization_view OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 23884)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 23887)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 2248 (class 0 OID 0)
-- Dependencies: 203
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE migrations_id_seq OWNED BY migrations.id;


--
-- TOC entry 204 (class 1259 OID 23889)
-- Name: public_advertisement_schedule; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public_advertisement_schedule AS
    SELECT adsch.id, adsch.name, adsch.large_image_path, adsch.medium_image_path, adsch.start_datetime, adsch.end_datetime, adsch.created_at, adsch.updated_at, adsch.is_deleted FROM advertisement_schedule adsch WHERE ((((((adsch.is_deleted = false) AND ((adsch.end_datetime IS NULL) OR (adsch.end_datetime >= now()))) AND (adsch.large_image_path IS NOT NULL)) AND (adsch.large_image_path <> ''::text)) AND (adsch.medium_image_path IS NOT NULL)) AND (adsch.medium_image_path <> ''::text));


ALTER TABLE public.public_advertisement_schedule OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 23893)
-- Name: specialization_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE specialization_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.specialization_id_seq OWNER TO postgres;

--
-- TOC entry 2249 (class 0 OID 0)
-- Dependencies: 205
-- Name: specialization_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE specialization_id_seq OWNED BY specialization.id;


--
-- TOC entry 206 (class 1259 OID 23895)
-- Name: sub_specialization; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sub_specialization (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    updated_at timestamp without time zone DEFAULT (timezone('UTC'::text, now()) + '08:00:00'::interval),
    is_active smallint DEFAULT 1
);


ALTER TABLE public.sub_specialization OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 23901)
-- Name: sub_specialization_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sub_specialization_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sub_specialization_id_seq OWNER TO postgres;

--
-- TOC entry 2250 (class 0 OID 0)
-- Dependencies: 207
-- Name: sub_specialization_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sub_specialization_id_seq OWNED BY sub_specialization.id;


--
-- TOC entry 208 (class 1259 OID 23903)
-- Name: sub_specialization_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW sub_specialization_view AS
    SELECT a.id, a.name, a.type, a.created_at, a.updated_at, a.is_active FROM admin_specialization a WHERE (a.type = 'sub'::text);


ALTER TABLE public.sub_specialization_view OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 23907)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 2251 (class 0 OID 0)
-- Dependencies: 209
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 1991 (class 2604 OID 23909)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY advertisement_schedule ALTER COLUMN id SET DEFAULT nextval('advertisement_schedule_id_seq'::regclass);


--
-- TOC entry 1995 (class 2604 OID 23910)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor ALTER COLUMN id SET DEFAULT nextval('doctor_id_seq'::regclass);


--
-- TOC entry 1999 (class 2604 OID 23911)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_busy_schedule ALTER COLUMN id SET DEFAULT nextval('doctor_busy_schedule_id_seq'::regclass);


--
-- TOC entry 2002 (class 2604 OID 23912)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_clinic ALTER COLUMN id SET DEFAULT nextval('doctor_clinic_id_seq'::regclass);


--
-- TOC entry 2005 (class 2604 OID 23913)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_hmo ALTER COLUMN id SET DEFAULT nextval('doctor_hmo_id_seq'::regclass);


--
-- TOC entry 2028 (class 2604 OID 23914)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_queue ALTER COLUMN id SET DEFAULT nextval('doctor_queue_id_seq'::regclass);


--
-- TOC entry 2009 (class 2604 OID 23915)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_schedule ALTER COLUMN id SET DEFAULT nextval('doctor_schedule_id_seq'::regclass);


--
-- TOC entry 2012 (class 2604 OID 23916)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_specialization ALTER COLUMN id SET DEFAULT nextval('doctor_specialization_id_seq'::regclass);


--
-- TOC entry 2021 (class 2604 OID 23917)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_user_assign ALTER COLUMN id SET DEFAULT nextval('doctor_user_assign_id_seq'::regclass);


--
-- TOC entry 2016 (class 2604 OID 23918)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hmo ALTER COLUMN id SET DEFAULT nextval('hmo_id_seq'::regclass);


--
-- TOC entry 2031 (class 2604 OID 23919)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY migrations ALTER COLUMN id SET DEFAULT nextval('migrations_id_seq'::regclass);


--
-- TOC entry 2020 (class 2604 OID 23920)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specialization ALTER COLUMN id SET DEFAULT nextval('specialization_id_seq'::regclass);


--
-- TOC entry 2035 (class 2604 OID 23921)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sub_specialization ALTER COLUMN id SET DEFAULT nextval('sub_specialization_id_seq'::regclass);


--
-- TOC entry 2027 (class 2604 OID 23922)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 2202 (class 0 OID 23730)
-- Dependencies: 169
-- Data for Name: advertisement_schedule; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY advertisement_schedule (id, large_image_path, medium_image_path, start_datetime, end_datetime, created_at, updated_at, is_deleted, is_active, name) FROM stdin;
4	BjtpesT9AH3OfPzpQxv9qkw8mSkL6FJfi7IlBNIS.png	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:29:09.568	2025-05-10 13:32:22.462	t	1	mamama
6	Z0gKzqZ53ND783Tz6TLLRkGrovT4pQeAFvjAm3Yy.png	ayPLBP9AxfGXVylk6470I1sObvr9sLerTXY3rnbi.png	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:33:07.262	2025-05-10 13:33:07.262	t	1	a
7	0TsW0Q6emYfypUbxuwCIBsgKy51ESS9wrv19G8zh.png	Zovo772Ht3RdCvHkYXBFgyQ7gZUKMouaHVtMoClR.png	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:34:46.696	2025-05-10 13:34:46.696	t	1	aaaa
8	LaqtilqNvB0kLtLVK9yxYM5I9yaI64jPy2d3mwO7.png	nbxJ3JmE06kJ2YrafMYzsDkXwFgBjd1nJs6FPOTl.png	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:39:22.907	2025-05-10 13:39:22.907	t	1	zzz
9	5u1g8UzILzBHKFTCiFgXFghxB6UTwtexuVaO7Dhn.png	Rdyj64Gt3TvikMu952LHkodJarIe6EIm9l1Xgo9D.png	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:40:10.474	2025-05-10 13:40:10.474	t	1	zzzzzz
10	bWVBALpgAlmxBlxE0m0WpTcdKb6BW1TtcrWSppC8.png	uKx6FePiOGQsQuEu0ZSloynJG5QuS9ZkScYIyosm.png	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:42:44.641	2025-05-10 13:42:44.641	f	1	qweqwewq
11	5jAM4Z2qSDkPIAbmminbLZQrPhIrxREob2iRWsnF.png	Cb5otvvJMfyCZPNPtFxI92KHAeRe36Kz5TVHnybe.png	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:44:48.705	2025-05-10 13:44:48.705	f	1	zxczxcxz
1	\N	\N	2025-05-09 00:00:00	2025-05-09 23:59:59	2025-05-09 18:13:57.349	2025-05-10 00:01:57.821	t	1	\N
15	\N	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:50:54.86	2025-05-10 13:50:54.86	f	1	
16	\N	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 14:05:54.939	2025-05-10 14:05:54.939	t	1	qcqwcqwcqwcqw
12	\N	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:46:21.918	2025-05-10 13:46:21.918	t	1	zzz
13	9x3tLXvesX3RR2MACSEIyN7ObBmhJZT9TqHANsvS.png	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:46:26.584	2025-05-10 13:46:26.584	t	1	
14	\N	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:46:30.133	2025-05-10 13:46:30.133	t	1	
2	\N	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-09 23:55:41.104	2025-05-10 00:31:46.084	t	1	\N
3	\N	\N	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 00:27:41.737	2025-05-10 13:12:42.051	t	1	eqwe
5	Q1hfMHeJ6yLhoohX8Prq7WfC7rkQdQROY1vL10ED.png	R83AGP4WdQKAMez8iamSa14dLFEWwBQ39pXwLdtq.png	2025-05-10 00:00:00	2025-05-10 23:59:59	2025-05-10 13:32:15.528	2025-05-10 13:32:15.528	t	1	d
17	\N	\N	2025-05-13 10:30:00	2025-05-13 14:00:00	2025-05-13 09:53:45.331	2025-05-13 10:16:56.574	t	1	hered
18	\N	\N	2025-05-13 00:00:00	2025-05-13 23:59:59	2025-05-13 10:30:09.634	2025-05-13 10:34:15.449	t	1	sale
19	\N	\N	2025-05-14 00:00:00	2025-05-14 23:59:59	2025-05-13 10:35:12.757	2025-05-13 10:53:53.776	t	1	sale
25	\N		2025-05-13 00:00:00	2025-05-13 23:59:59	2025-05-13 13:45:49.482	2025-05-13 13:45:49.482	t	1	not active
26	2aiL9NgELDaOZYHMDWOMKOyR9cizglMFGmbELdd2.png	XiAp6rKlMl5rOdeOXwEZFwLHv7YjndJ2KgrgxBlu.png	2025-05-14 00:00:00	2025-06-14 23:59:59	2025-05-13 13:45:58.967	2025-05-14 14:36:19.929	t	1	not active
24	\N		2025-05-13 00:00:00	2025-05-13 23:59:59	2025-05-13 13:45:09.972	2025-05-13 13:45:09.972	t	1	not active
20	th6ktVOkwheswf6bpQAlHrMf0y7uUc1ato4fiRYV.png	zvX5d68Vqm13vkwtdxjlt2vYlYprdZ42PCGSTNUs.png	2025-05-13 00:00:00	2025-07-13 23:59:59	2025-05-13 10:54:11.686	2025-05-13 15:04:10.787	f	1	medicine sale
21	E8EMwmEhuPo6EUP1vHcP1PjUluFmyZ0p3TnwwaS8.png	DkurbEcqFIlgNwy4BhrqV2hyw79fBuwJWkWF0Aib.png	2025-05-13 00:00:00	2025-07-13 23:59:59	2025-05-13 11:27:11.13	2025-05-13 11:27:11.13	t	1	SALE
22	IiwWECYVgm8U6CZZtxt21sgZhQoDFMsVHvtrytMt.png	y45EQnF3Fc0s2dkR2FIYQMU7nSc1Dy1DMJh12jbO.png	2025-05-13 00:00:00	2025-07-13 23:59:59	2025-05-13 12:28:05.593	2025-05-13 15:04:06.809	f	1	medical certificate sale
23	qEoE0L77Nrk0uBVEFSPAD8vzO9WRYNgp8WpHvFDc.png	qYtgliEAdiia6qJxkgH5OYBV1th0pAP8NlaCugxR.png	2025-05-13 00:00:00	2025-07-13 23:59:59	2025-05-13 00:00:00	2025-05-13 15:04:14.353	f	1	insurance promotion
\.


--
-- TOC entry 2252 (class 0 OID 0)
-- Dependencies: 185
-- Name: advertisement_schedule_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('advertisement_schedule_id_seq', 26, true);


--
-- TOC entry 2203 (class 0 OID 23744)
-- Dependencies: 171
-- Data for Name: doctor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor (id, first_name, last_name, middle_name, suffix, date_of_birth, image, is_active, created_at, updated_at, image_path, contact_number, is_deleted) FROM stdin;
4	Cynthia	Torres	Mendoza	          	1985-03-15 00:00:00	\N	1	2025-03-24 09:14:21.95	2025-04-22 11:03:08.997	o2ubZbKAJRokd9dnR6hwN52hQz8OWjE3llgaWNyQ.jpg	0922-4728-5874	f
1	Jose	Ramos	Dela Cruz	          	1975-05-12 00:00:00	\\x6176617461722d342e6a7067	1	2025-03-24 09:14:21.95	2025-04-22 11:04:22.556	VsoewIunsKDwwzPSRJiQ55U4FKC5lEPGAivdT5eS.jpg	0923-3183-7584	f
2	Minette	Obscalon	Martinez	L         	1984-03-01 00:00:00	\\x6176617461722d322e6a7067	1	2025-03-24 09:14:21.95	2025-04-29 11:48:50.681	gvK4cTgMv2QdU8mT38nORMiiArVDxIv4CjlEJwFg.jpg	0932-423-1234	f
41	\N	\N	\N	\N	\N	\N	1	2025-04-22 10:56:24.898	2025-04-27 14:44:44.669	QbrSbArFkwq3E4N8eS6p0z1wMfUpIIJkJGKEKVZB.jpg	\N	t
52	amamamama	mamamdsam		          	\N	\N	1	2025-04-29 14:42:34.781	2025-04-29 14:42:34.781	\N		t
51	aaaaaa	aaaaaa		          	\N	\N	1	2025-04-28 18:31:02.521	2025-04-29 11:26:19.072	\N		t
53	aaamamama	aamamama		          	\N	\N	1	2025-04-29 14:47:52.063	2025-04-29 14:47:52.063	\N		t
54	aaaaaaaaa	aaaaaa		          	\N	\N	1	2025-04-29 14:56:52.895	2025-04-29 14:56:52.895	\N		t
55	aaaaaaa	aaaaaaaaaaaaaaavb		          	\N	\N	1	2025-04-29 14:57:53.388	2025-04-29 14:57:53.388	\N		t
3	Antonio	Lopez	Reyes	Jr.       	1970-11-10 00:00:00	\\x6176617461722d362e6a7067	1	2025-03-24 09:14:21.95	2025-04-22 10:59:18.34	U5Yq2ejbUoDa1YkT8whbRJUz1Zp9jj356S1o575L.jpg	0947-3192-9932	f
56	amamama	aamamam		          	\N	\N	1	2025-04-29 15:08:40.778	2025-04-29 15:08:40.778	\N		t
57	aaaaaaaa	aaakqkqwwqknd		          	\N	\N	1	2025-04-29 15:10:06.645	2025-04-29 15:10:06.645	\N		t
10	Rossiette	Sipalay	Palawan	S         	2022-02-09 00:00:00	\N	1	2025-04-06 00:03:55.058	2025-05-05 00:15:27.942	zuiicHxS4fSNYWm2RHcz3IDGXb7y6i0kQ9Y8GDbD.jpg	09929270	f
5	Ken	Fernandez	Cruz	I         	1978-12-01 00:00:00	\N	1	2025-03-24 09:14:21.95	2025-05-19 11:51:18.559	MqnnVappniKwPVxUNcq7huv1rCYqLPVQhGczxrg8.jpg	0981-595-2374	f
49	Marcoa	Quanico	Angelo	          	2025-04-10 00:00:00	\N	1	2025-04-27 22:45:31.572	2025-04-27 22:45:31.572	\N	09213428390	t
58	Marcod	Quanico	Angelo	          	\N	\N	1	2025-05-10 13:37:23.107	2025-05-10 13:37:23.107	805wmtWVTIcjRypB9cyLakwNtXHd9rdukWrvCDdt.png	09213428390	t
\.


--
-- TOC entry 2204 (class 0 OID 23753)
-- Dependencies: 172
-- Data for Name: doctor_busy_schedule; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor_busy_schedule (id, doctor_id, start_datetime, end_datetime, is_deleted, created_at, updated_at) FROM stdin;
34	3	2025-05-08 07:00:00	2025-05-08 13:00:00	t	2025-05-08 11:55:41.039	2025-05-08 11:55:41.039
35	3	2025-05-08 00:00:00	2025-05-08 23:59:59	f	2025-05-08 11:59:18.034	2025-05-08 11:59:18.034
43	3	2025-05-13 00:00:00	2025-05-13 23:59:59	f	2025-05-08 12:27:04.311	2025-05-08 12:27:04.311
44	3	2025-05-10 00:00:00	2025-05-10 23:59:59	f	2025-05-08 12:29:08.927	2025-05-08 12:29:08.927
62	5	2025-05-10 00:00:00	2025-06-07 23:59:59	t	2025-05-08 14:17:47.707	2025-05-08 14:17:47.707
54	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 12:55:47.253	2025-05-08 12:55:47.253
56	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 13:46:30.955	2025-05-08 13:46:30.955
52	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 12:53:54.613	2025-05-08 12:53:54.613
28	5	2025-05-08 18:00:00	2025-05-08 18:30:00	t	2025-05-08 11:08:48.483	2025-05-08 11:08:48.483
29	5	2025-05-08 18:50:00	2025-05-08 19:30:00	t	2025-05-08 11:09:24.869	2025-05-08 11:09:24.869
30	5	2025-05-09 01:00:00	2025-05-09 07:00:00	t	2025-05-08 11:20:17.654	2025-05-08 11:20:17.654
31	5	2025-05-08 17:30:00	2025-05-08 18:30:00	t	2025-05-08 11:20:49.721	2025-05-08 11:20:49.721
32	5	2025-05-08 18:30:00	2025-05-08 18:50:00	t	2025-05-08 11:21:23.317	2025-05-08 11:21:23.317
33	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 11:54:15.327	2025-05-08 11:54:15.327
36	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 11:59:29.602	2025-05-08 11:59:29.602
37	5	2025-05-08 00:01:00	2025-05-08 23:59:00	t	2025-05-08 12:01:39.878	2025-05-08 12:01:39.878
38	5	2025-05-08 12:01:00	2025-05-08 23:59:00	t	2025-05-08 12:02:09.829	2025-05-08 12:02:09.829
1	5	2025-05-06 00:00:00	2025-05-06 23:59:59	t	2025-05-06 10:57:58.913	2025-05-06 10:57:58.913
2	5	2025-05-07 00:00:00	2025-05-07 23:59:59	t	2025-05-06 10:58:22.182	2025-05-06 10:58:22.182
3	5	2025-05-08 00:00:00	2025-05-09 23:59:59	t	2025-05-06 11:14:42.918	2025-05-06 11:14:42.918
4	5	2025-05-06 03:22:00	2025-05-06 18:22:00	t	2025-05-06 11:22:35.849	2025-05-06 11:22:35.849
5	5	2025-05-07 00:00:00	2025-05-07 23:59:59	t	2025-05-07 11:14:22.814	2025-05-07 11:14:22.814
6	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-07 11:21:41.085	2025-05-07 11:21:41.085
7	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-07 11:23:49.752	2025-05-07 11:23:49.752
58	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 14:02:29.32	2025-05-08 14:02:29.32
60	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 14:12:22.785	2025-05-08 14:12:22.785
64	5	2025-05-19 00:00:00	2025-05-22 23:59:59	t	2025-05-08 20:46:02.891	2025-05-08 20:46:02.891
59	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 14:09:36.068	2025-05-08 14:09:36.068
61	5	2025-05-10 00:00:00	2025-05-22 23:59:59	t	2025-05-08 14:12:34.922	2025-05-08 14:12:34.922
55	5	2025-05-17 00:00:00	2025-05-22 23:59:59	t	2025-05-08 13:44:09.721	2025-05-08 13:44:09.721
51	5	2025-05-09 13:00:00	2025-05-09 20:00:00	t	2025-05-08 12:51:30.751	2025-05-08 12:51:30.751
8	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-07 11:26:05.784	2025-05-07 11:26:05.784
9	5	2025-05-07 00:00:00	2025-05-07 23:59:59	t	2025-05-07 13:28:50.972	2025-05-07 13:28:50.972
10	5	2025-05-07 00:00:00	2025-05-07 23:59:59	t	2025-05-07 13:29:49.56	2025-05-07 13:29:49.56
11	5	2025-05-07 00:00:00	2025-05-07 23:59:59	t	2025-05-07 13:36:43.978	2025-05-07 13:36:43.978
12	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-07 14:04:31.682	2025-05-07 14:04:31.682
13	5	2025-05-07 00:00:00	2025-05-07 23:59:59	t	2025-05-07 14:52:27.502	2025-05-07 14:52:27.502
14	5	2025-05-07 00:00:00	2025-05-07 23:59:59	t	2025-05-07 14:56:45.843	2025-05-07 14:56:45.843
15	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-07 14:57:01.565	2025-05-07 14:57:01.565
16	5	2025-05-10 00:00:00	2025-05-17 23:59:59	t	2025-05-07 16:15:54.297	2025-05-07 16:15:54.297
17	5	2025-05-10 00:00:00	2025-05-23 23:59:59	t	2025-05-07 16:32:15.834	2025-05-07 16:32:15.834
18	5	2025-05-08 17:43:00	2025-05-08 22:43:00	t	2025-05-07 16:43:33.248	2025-05-07 16:43:33.248
19	5	2025-05-08 19:00:00	2025-05-08 20:00:00	t	2025-05-07 17:25:44.229	2025-05-07 17:25:44.229
21	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 10:13:49.701	2025-05-08 10:13:49.701
22	5	2025-05-08 13:00:00	2025-05-08 22:00:00	t	2025-05-08 10:27:56.237	2025-05-08 10:27:56.237
23	5	2025-05-08 13:00:00	2025-05-08 22:00:00	t	2025-05-08 10:28:50.297	2025-05-08 10:28:50.297
20	5	2025-05-08 16:35:00	2025-05-08 17:10:00	t	2025-05-07 21:33:47.255	2025-05-07 21:33:47.255
25	5	2025-05-08 16:00:00	2025-05-08 21:00:00	t	2025-05-08 10:40:44.697	2025-05-08 10:40:44.697
26	5	2025-05-08 16:00:00	2025-05-08 18:00:00	t	2025-05-08 10:41:08.53	2025-05-08 10:41:08.53
27	5	2025-05-08 16:00:00	2025-05-08 17:30:00	t	2025-05-08 11:06:21.069	2025-05-08 11:06:21.069
39	5	2025-05-08 17:30:00	2025-05-08 18:00:00	t	2025-05-08 12:07:39.628	2025-05-08 12:07:39.628
40	5	2025-05-08 17:30:00	2025-05-08 18:00:00	t	2025-05-08 12:12:01.796	2025-05-08 12:12:01.796
41	5	2025-05-08 18:30:00	2025-05-08 20:30:00	t	2025-05-08 12:12:27.49	2025-05-08 12:12:27.49
42	5	2025-05-08 16:30:00	2025-05-08 19:00:00	t	2025-05-08 12:14:28.373	2025-05-08 12:14:28.373
45	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 12:33:15.328	2025-05-08 12:33:15.328
46	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 12:45:44.01	2025-05-08 12:45:44.01
47	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 12:45:44.025	2025-05-08 12:45:44.025
48	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 12:47:11.094	2025-05-08 12:47:11.094
49	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 12:47:11.106	2025-05-08 12:47:11.106
50	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 12:49:21.11	2025-05-08 12:49:21.11
53	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 12:54:01.622	2025-05-08 12:54:01.622
57	5	2025-05-08 00:00:00	2025-05-08 23:59:59	t	2025-05-08 14:02:25.837	2025-05-08 14:02:25.837
63	5	2025-05-09 00:00:00	2025-05-09 23:59:59	t	2025-05-08 20:45:12.422	2025-05-08 20:45:12.422
65	5	2025-05-22 00:00:00	2025-05-22 23:59:59	t	2025-05-19 11:48:36.096	2025-05-19 11:48:36.096
66	5	2025-05-22 00:00:00	2025-05-22 23:59:59	t	2025-05-19 11:48:36.113	2025-05-19 11:48:36.113
67	5	2025-05-22 00:00:00	2025-05-22 23:59:59	t	2025-05-19 11:48:36.113	2025-05-19 11:48:36.113
68	5	2025-05-19 00:00:00	2025-05-19 23:59:59	t	2025-05-19 11:49:04.393	2025-05-19 11:49:04.393
69	5	2025-05-19 00:00:00	2025-05-19 23:59:59	t	2025-05-19 11:49:04.393	2025-05-19 11:49:04.393
70	5	2025-05-19 00:00:00	2025-05-19 23:59:59	t	2025-05-19 11:49:04.393	2025-05-19 11:49:04.393
71	5	2025-05-19 00:00:00	2025-05-19 23:59:59	f	2025-05-19 11:51:26.185	2025-05-19 11:51:26.185
72	5	2025-05-22 00:00:00	2025-05-22 23:59:59	f	2025-05-19 11:51:35.006	2025-05-19 11:51:35.006
73	5	2025-05-26 00:00:00	2025-05-26 23:59:59	f	2025-05-20 13:48:50.613	2025-05-20 13:48:50.613
74	5	2025-05-25 00:00:00	2025-05-25 23:59:59	f	2025-05-20 13:49:34.04	2025-05-20 13:49:34.04
\.


--
-- TOC entry 2253 (class 0 OID 0)
-- Dependencies: 189
-- Name: doctor_busy_schedule_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_busy_schedule_id_seq', 74, true);


--
-- TOC entry 2205 (class 0 OID 23759)
-- Dependencies: 173
-- Data for Name: doctor_clinic; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor_clinic (id, code_name, doctor_id, created_at, updated_at) FROM stdin;
36	demo code name	41	2025-04-22 10:56:24.898	2025-04-22 10:56:24.898
3	ENG 176	3	2025-03-28 11:28:26.662	2025-03-28 11:28:26.662
4	CEP 231	4	2025-03-28 11:28:37.384	2025-03-28 11:28:37.384
1	MAB 2599	1	2025-03-28 11:27:58.96	2025-03-28 11:27:58.96
44		49	2025-04-27 22:45:31.572	2025-04-27 22:45:31.572
46		51	2025-04-28 18:31:02.521	2025-04-28 18:31:02.521
2	MAB 259	2	2025-03-28 11:28:07.747	2025-03-28 11:28:07.747
47		52	2025-04-29 14:42:34.781	2025-04-29 14:42:34.781
48		53	2025-04-29 14:47:52.063	2025-04-29 14:47:52.063
49		54	2025-04-29 14:56:52.895	2025-04-29 14:56:52.895
50		55	2025-04-29 14:57:53.388	2025-04-29 14:57:53.388
51		56	2025-04-29 15:08:40.778	2025-04-29 15:08:40.778
52		57	2025-04-29 15:10:06.645	2025-04-29 15:10:06.645
20	DELULU	10	2025-04-09 15:01:16.869	2025-04-09 15:01:16.869
5	USE 773	5	2025-03-28 11:28:52.119	2025-03-28 11:28:52.119
53		58	2025-05-10 13:37:23.107	2025-05-10 13:37:23.107
\.


--
-- TOC entry 2254 (class 0 OID 0)
-- Dependencies: 190
-- Name: doctor_clinic_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_clinic_id_seq', 53, true);


--
-- TOC entry 2206 (class 0 OID 23764)
-- Dependencies: 174
-- Data for Name: doctor_hmo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor_hmo (id, doctor_id, hmo_id, is_active, created_at, updated_at) FROM stdin;
610	1	1	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
611	1	2	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
612	1	5	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
613	1	6	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
614	1	8	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
615	1	12	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
616	1	14	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
617	1	26	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
618	1	28	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
619	1	34	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
620	1	37	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
621	1	49	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
622	1	50	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
623	1	57	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
624	1	58	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
625	1	61	\N	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
542	3	3	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
543	3	6	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
544	3	8	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
545	3	16	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
546	3	18	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
547	3	22	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
548	3	23	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
549	3	40	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
550	3	45	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
551	3	47	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
552	3	54	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
553	3	61	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
554	3	63	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
555	3	64	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
556	3	65	\N	2025-04-22 10:59:18.34	2025-04-22 10:59:18.34
588	4	3	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
589	4	6	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
590	4	7	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
591	4	9	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
592	4	10	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
593	4	13	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
594	4	17	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
595	4	18	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
596	4	19	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
597	4	20	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
598	4	21	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
599	4	29	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
600	4	34	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
601	4	36	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
602	4	41	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
603	4	50	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
604	4	53	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
605	4	55	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
606	4	57	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
607	4	58	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
608	4	61	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
609	4	66	\N	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
638	41	5	\N	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
639	41	27	\N	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
640	41	28	\N	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
641	41	29	\N	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
642	41	30	\N	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
643	41	31	\N	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
732	49	3	1	2025-04-27 22:45:31.572	2025-04-27 22:45:31.572
733	51	5	\N	2025-04-29 11:26:19.072	2025-04-29 11:26:19.072
734	2	5	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
735	2	6	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
736	2	12	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
737	2	21	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
738	2	25	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
739	2	27	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
740	2	34	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
741	2	35	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
742	2	37	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
743	2	38	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
744	2	43	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
745	2	48	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
746	2	49	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
747	2	50	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
748	2	51	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
749	2	53	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
750	2	54	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
751	2	60	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
752	2	62	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
753	2	65	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
754	2	66	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
755	2	67	\N	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
756	10	3	\N	2025-05-05 00:15:27.942	2025-05-05 00:15:27.942
757	10	5	\N	2025-05-05 00:15:27.942	2025-05-05 00:15:27.942
758	10	6	\N	2025-05-05 00:15:27.942	2025-05-05 00:15:27.942
759	5	1	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
760	5	4	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
761	5	11	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
762	5	12	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
763	5	15	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
764	5	17	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
765	5	24	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
766	5	26	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
767	5	27	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
768	5	34	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
769	5	37	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
770	5	38	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
771	5	44	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
772	5	45	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
773	5	47	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
774	5	49	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
775	5	50	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
776	5	59	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
777	5	61	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
778	5	63	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
779	5	67	\N	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
\.


--
-- TOC entry 2255 (class 0 OID 0)
-- Dependencies: 191
-- Name: doctor_hmo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_hmo_id_seq', 779, true);


--
-- TOC entry 2256 (class 0 OID 0)
-- Dependencies: 192
-- Name: doctor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_id_seq', 58, true);


--
-- TOC entry 2218 (class 0 OID 23852)
-- Dependencies: 193
-- Data for Name: doctor_queue; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor_queue (id, doctor_id, declared_full_name, specialization_id, declared_remarks, assisted, assistance_notes, created_by) FROM stdin;
\.


--
-- TOC entry 2257 (class 0 OID 0)
-- Dependencies: 194
-- Name: doctor_queue_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_queue_id_seq', 1, false);


--
-- TOC entry 2207 (class 0 OID 23769)
-- Dependencies: 175
-- Data for Name: doctor_schedule; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor_schedule (id, doctor_id, start_time, end_time, day_of_week, visit_type, created_at, updated_at, is_deleted) FROM stdin;
1	1	06:00:00	09:00:00	monday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
2	1	06:00:00	09:00:00	tuesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
4	1	06:00:00	09:00:00	thursday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
5	1	06:00:00	09:00:00	friday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
21	3	08:00:00	11:00:00	monday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
22	3	08:00:00	11:00:00	tuesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
23	3	08:00:00	11:00:00	wednesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
24	3	08:00:00	11:00:00	thursday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
25	3	08:00:00	11:00:00	friday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
26	3	13:00:00	16:00:00	monday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
27	3	13:00:00	16:00:00	tuesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
28	3	13:00:00	16:00:00	wednesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
29	3	13:00:00	16:00:00	thursday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
30	3	13:00:00	16:00:00	friday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
31	4	09:00:00	12:00:00	monday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
32	4	09:00:00	12:00:00	tuesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
33	4	09:00:00	12:00:00	wednesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
34	4	09:00:00	12:00:00	thursday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
35	4	09:00:00	12:00:00	friday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
36	4	14:00:00	17:00:00	monday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
37	4	14:00:00	17:00:00	tuesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
38	4	14:00:00	17:00:00	wednesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
39	4	14:00:00	17:00:00	thursday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
40	4	14:00:00	17:00:00	friday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
3	1	06:00:00	09:00:00	sunday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
7	10	09:00:00	18:00:00	monday	walk-in	2025-04-09 14:33:55.334	2025-04-09 14:33:55.334	f
51	1	09:00:00	15:00:00	wednesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	f
56	10	06:30:00	12:30:00	thursday	appointment	2025-04-19 23:59:04.66	2025-04-19 23:59:04.66	f
57	10	13:00:00	21:00:00	saturday	appointment	2025-04-21 10:39:35.979	2025-04-21 10:39:35.979	f
58	10	13:00:00	21:00:00	sunday	appointment	2025-04-21 10:39:35.979	2025-04-21 10:39:35.979	f
65	10	23:00:00	12:00:00	monday	walk-in	2025-04-21 10:46:17.982	2025-04-21 10:46:17.982	f
66	10	23:00:00	12:00:00	tuesday	walk-in	2025-04-21 10:46:17.982	2025-04-21 10:46:17.982	f
67	10	23:00:00	12:00:00	wednesday	walk-in	2025-04-21 10:46:17.982	2025-04-21 10:46:17.982	f
68	10	23:00:00	12:00:00	thursday	walk-in	2025-04-21 10:46:17.982	2025-04-21 10:46:17.982	f
69	10	23:00:00	12:00:00	friday	walk-in	2025-04-21 10:46:17.982	2025-04-21 10:46:17.982	f
70	10	23:00:00	12:00:00	saturday	walk-in	2025-04-21 10:46:17.982	2025-04-21 10:46:17.982	f
71	10	23:00:00	12:00:00	sunday	walk-in	2025-04-21 10:46:17.982	2025-04-21 10:46:17.982	f
19	2	15:00:00	18:00:00	saturday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
17	2	15:00:00	18:00:00	tuesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
13	2	07:00:00	10:00:00	wednesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
15	2	07:00:00	10:00:00	friday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
11	2	07:00:00	10:00:00	monday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
10	2	01:00:00	11:00:00	sunday	appointment	2025-04-16 15:28:43.882	2025-04-16 15:28:43.882	t
52	2	13:00:00	21:00:00	thursday	appointment	2025-04-16 15:35:20.855	2025-04-16 15:35:20.855	t
55	2	13:00:00	23:00:00	monday	walk-in	2025-04-16 15:39:44.921	2025-04-16 15:39:44.921	t
14	2	07:00:00	11:00:00	sunday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
12	2	07:00:00	10:00:00	tuesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
72	2	00:00:00	04:00:00	monday	appointment	2025-04-22 09:55:24.112	2025-04-22 09:55:24.112	f
73	2	00:00:00	04:00:00	tuesday	appointment	2025-04-22 09:55:24.112	2025-04-22 09:55:24.112	f
74	2	00:00:00	04:00:00	wednesday	appointment	2025-04-22 09:55:24.112	2025-04-22 09:55:24.112	f
75	2	00:00:00	04:00:00	thursday	appointment	2025-04-22 09:55:24.112	2025-04-22 09:55:24.112	f
76	2	00:00:00	04:00:00	friday	appointment	2025-04-22 09:55:24.112	2025-04-22 09:55:24.112	f
77	2	00:00:00	04:00:00	saturday	appointment	2025-04-22 09:55:24.112	2025-04-22 09:55:24.112	f
78	2	00:00:00	04:00:00	sunday	appointment	2025-04-22 09:55:24.112	2025-04-22 09:55:24.112	f
79	2	18:00:00	20:00:00	monday	walk-in	2025-04-22 09:55:39.634	2025-04-22 09:55:39.634	f
80	2	18:00:00	20:00:00	tuesday	walk-in	2025-04-22 09:55:39.634	2025-04-22 09:55:39.634	f
81	2	18:00:00	20:00:00	wednesday	walk-in	2025-04-22 09:55:39.634	2025-04-22 09:55:39.634	f
82	2	18:00:00	20:00:00	thursday	walk-in	2025-04-22 09:55:39.634	2025-04-22 09:55:39.634	f
83	2	18:00:00	20:00:00	friday	walk-in	2025-04-22 09:55:39.634	2025-04-22 09:55:39.634	f
84	41	00:00:00	16:00:00	monday	appointment	2025-04-22 10:56:54.612	2025-04-22 10:56:54.612	f
85	41	00:00:00	16:00:00	tuesday	appointment	2025-04-22 10:56:54.612	2025-04-22 10:56:54.612	f
86	41	00:00:00	16:00:00	wednesday	appointment	2025-04-22 10:56:54.612	2025-04-22 10:56:54.612	f
87	41	00:00:00	16:00:00	thursday	appointment	2025-04-22 10:56:54.612	2025-04-22 10:56:54.612	f
88	41	00:00:00	16:00:00	friday	appointment	2025-04-22 10:56:54.612	2025-04-22 10:56:54.612	f
89	41	00:00:00	16:00:00	saturday	appointment	2025-04-22 10:56:54.612	2025-04-22 10:56:54.612	f
90	41	00:00:00	16:00:00	sunday	appointment	2025-04-22 10:56:54.612	2025-04-22 10:56:54.612	f
177	5	09:00:00	11:00:00	monday	appointment	2025-05-08 12:34:58.248	2025-05-08 12:34:58.248	t
124	5	23:00:00	01:00:00	tuesday	walk-in	2025-05-06 11:36:56.601	2025-05-06 11:36:56.601	t
125	5	23:00:00	01:00:00	wednesday	walk-in	2025-05-06 11:36:56.601	2025-05-06 11:36:56.601	t
126	5	23:00:00	01:00:00	thursday	walk-in	2025-05-06 11:36:56.601	2025-05-06 11:36:56.601	t
127	5	23:00:00	01:00:00	friday	walk-in	2025-05-06 11:36:56.601	2025-05-06 11:36:56.601	t
128	5	23:00:00	01:00:00	saturday	walk-in	2025-05-06 11:36:56.601	2025-05-06 11:36:56.601	t
129	5	23:00:00	01:00:00	sunday	walk-in	2025-05-06 11:36:56.601	2025-05-06 11:36:56.601	t
132	5	00:00:00	00:00:00	monday	walk-in	2025-05-07 13:32:02.738	2025-05-07 13:32:02.738	t
133	5	00:00:00	00:00:00	tuesday	walk-in	2025-05-07 13:32:02.738	2025-05-07 13:32:02.738	t
134	5	00:00:00	00:00:00	wednesday	walk-in	2025-05-07 13:32:02.738	2025-05-07 13:32:02.738	t
135	5	00:00:00	00:00:00	thursday	walk-in	2025-05-07 13:32:02.738	2025-05-07 13:32:02.738	t
136	5	00:00:00	00:00:00	friday	walk-in	2025-05-07 13:32:02.738	2025-05-07 13:32:02.738	t
137	5	00:00:00	00:00:00	saturday	walk-in	2025-05-07 13:32:02.738	2025-05-07 13:32:02.738	t
138	5	00:00:00	00:00:00	sunday	walk-in	2025-05-07 13:32:02.738	2025-05-07 13:32:02.738	t
139	5	00:00:00	00:00:00	monday	appointment	2025-05-07 13:35:53.688	2025-05-07 13:35:53.688	t
140	5	00:00:00	00:00:00	tuesday	appointment	2025-05-07 13:35:53.688	2025-05-07 13:35:53.688	t
141	5	00:00:00	00:00:00	wednesday	appointment	2025-05-07 13:35:53.688	2025-05-07 13:35:53.688	t
142	5	00:00:00	00:00:00	thursday	appointment	2025-05-07 13:35:53.688	2025-05-07 13:35:53.688	t
143	5	00:00:00	00:00:00	friday	appointment	2025-05-07 13:35:53.688	2025-05-07 13:35:53.688	t
153	5	00:00:00	00:00:00	monday	walk-in	2025-05-07 14:52:22.677	2025-05-07 14:52:22.677	t
154	5	00:00:00	00:00:00	tuesday	walk-in	2025-05-07 14:52:22.677	2025-05-07 14:52:22.677	t
155	5	00:00:00	00:00:00	wednesday	walk-in	2025-05-07 14:52:22.677	2025-05-07 14:52:22.677	t
156	5	00:00:00	00:00:00	thursday	walk-in	2025-05-07 14:52:22.677	2025-05-07 14:52:22.677	t
157	5	00:00:00	00:00:00	friday	walk-in	2025-05-07 14:52:22.677	2025-05-07 14:52:22.677	t
158	5	00:00:00	00:00:00	saturday	walk-in	2025-05-07 14:52:22.677	2025-05-07 14:52:22.677	t
159	5	00:00:00	00:00:00	sunday	walk-in	2025-05-07 14:52:22.677	2025-05-07 14:52:22.677	t
162	5	17:00:00	19:00:00	thursday	walk-in	2025-05-07 16:59:53.323	2025-05-07 16:59:53.323	t
163	5	02:00:00	06:00:00	monday	walk-in	2025-05-08 11:19:15.068	2025-05-08 11:19:15.068	t
164	5	02:00:00	06:00:00	tuesday	walk-in	2025-05-08 11:19:15.068	2025-05-08 11:19:15.068	t
178	5	09:00:00	11:00:00	monday	walk-in	2025-05-08 12:35:13.666	2025-05-08 12:35:13.666	t
179	5	09:00:00	11:00:00	tuesday	walk-in	2025-05-08 12:35:13.666	2025-05-08 12:35:13.666	t
180	5	09:00:00	11:00:00	wednesday	walk-in	2025-05-08 12:35:13.666	2025-05-08 12:35:13.666	t
181	5	09:00:00	11:00:00	thursday	walk-in	2025-05-08 12:35:13.666	2025-05-08 12:35:13.666	t
182	5	09:00:00	11:00:00	friday	walk-in	2025-05-08 12:35:13.666	2025-05-08 12:35:13.666	t
130	3	13:00:00	16:00:00	wednesday	walk-in	2025-05-07 10:48:45.679	2025-05-07 10:48:45.679	f
131	3	13:00:00	16:00:00	saturday	appointment	2025-05-07 10:49:09.718	2025-05-07 10:49:09.718	f
183	5	09:00:00	11:00:00	saturday	walk-in	2025-05-08 12:35:13.666	2025-05-08 12:35:13.666	t
184	5	09:00:00	11:00:00	sunday	walk-in	2025-05-08 12:35:13.666	2025-05-08 12:35:13.666	t
144	5	00:00:00	00:00:00	monday	appointment	2025-05-07 13:47:36.977	2025-05-07 13:47:36.977	t
145	5	00:00:00	00:00:00	tuesday	appointment	2025-05-07 13:47:36.977	2025-05-07 13:47:36.977	t
146	5	00:00:00	00:00:00	wednesday	appointment	2025-05-07 13:47:36.977	2025-05-07 13:47:36.977	t
147	5	00:00:00	00:00:00	thursday	appointment	2025-05-07 13:47:36.977	2025-05-07 13:47:36.977	t
148	5	00:00:00	00:00:00	friday	appointment	2025-05-07 13:47:36.977	2025-05-07 13:47:36.977	t
149	5	00:00:00	00:00:00	saturday	appointment	2025-05-07 13:47:36.977	2025-05-07 13:47:36.977	t
150	5	00:00:00	00:00:00	sunday	appointment	2025-05-07 13:47:36.977	2025-05-07 13:47:36.977	t
160	5	00:00:00	00:00:00	monday	appointment	2025-05-07 16:15:12.794	2025-05-07 16:15:12.794	t
151	5	00:00:00	00:00:00	saturday	walk-in	2025-05-07 13:55:29.435	2025-05-07 13:55:29.435	t
152	5	00:00:00	00:00:00	sunday	walk-in	2025-05-07 13:55:29.435	2025-05-07 13:55:29.435	t
41	5	07:30:00	10:30:00	monday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
42	5	07:30:00	10:30:00	tuesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
43	5	07:30:00	10:30:00	wednesday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
44	5	07:30:00	10:30:00	thursday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
45	5	07:30:00	10:30:00	friday	walk-in	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
46	5	15:00:00	18:00:00	monday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
47	5	15:00:00	18:00:00	tuesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
48	5	15:00:00	18:00:00	wednesday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
49	5	15:00:00	18:00:00	thursday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
50	5	15:00:00	18:00:00	friday	appointment	2025-03-28 11:38:08.49	2025-03-28 11:38:08.49	t
59	5	21:00:00	22:00:00	monday	walk-in	2025-04-21 10:43:10.785	2025-04-21 10:43:10.785	t
60	5	21:00:00	22:00:00	tuesday	walk-in	2025-04-21 10:43:10.785	2025-04-21 10:43:10.785	t
61	5	21:00:00	22:00:00	wednesday	walk-in	2025-04-21 10:43:10.785	2025-04-21 10:43:10.785	t
62	5	21:00:00	22:00:00	thursday	walk-in	2025-04-21 10:43:10.785	2025-04-21 10:43:10.785	t
63	5	21:00:00	22:00:00	friday	walk-in	2025-04-21 10:43:10.785	2025-04-21 10:43:10.785	t
91	5	00:00:00	00:30:00	monday	appointment	2025-05-05 14:02:23.089	2025-05-05 14:02:23.089	t
92	5	00:00:00	00:30:00	tuesday	appointment	2025-05-05 14:02:23.089	2025-05-05 14:02:23.089	t
93	5	00:00:00	00:30:00	wednesday	appointment	2025-05-05 14:02:23.089	2025-05-05 14:02:23.089	t
94	5	00:00:00	00:30:00	thursday	appointment	2025-05-05 14:02:23.089	2025-05-05 14:02:23.089	t
95	5	00:00:00	00:30:00	friday	appointment	2025-05-05 14:02:23.089	2025-05-05 14:02:23.089	t
96	5	00:00:00	00:30:00	saturday	appointment	2025-05-05 14:02:23.089	2025-05-05 14:02:23.089	t
97	5	00:00:00	00:30:00	sunday	appointment	2025-05-05 14:02:23.089	2025-05-05 14:02:23.089	t
98	5	13:00:00	23:00:00	monday	walk-in	2025-05-05 14:37:14.119	2025-05-05 14:37:14.119	t
99	5	13:00:00	23:00:00	tuesday	walk-in	2025-05-05 14:37:14.119	2025-05-05 14:37:14.119	t
165	5	02:00:00	06:00:00	wednesday	walk-in	2025-05-08 11:19:15.068	2025-05-08 11:19:15.068	t
166	5	02:00:00	06:00:00	thursday	walk-in	2025-05-08 11:19:15.068	2025-05-08 11:19:15.068	t
167	5	02:00:00	06:00:00	friday	walk-in	2025-05-08 11:19:15.068	2025-05-08 11:19:15.068	t
168	5	02:00:00	06:00:00	saturday	walk-in	2025-05-08 11:19:15.068	2025-05-08 11:19:15.068	t
169	5	02:00:00	06:00:00	sunday	walk-in	2025-05-08 11:19:15.068	2025-05-08 11:19:15.068	t
170	5	17:00:00	19:00:00	monday	walk-in	2025-05-08 12:34:07.518	2025-05-08 12:34:07.518	t
171	5	17:00:00	19:00:00	tuesday	walk-in	2025-05-08 12:34:07.518	2025-05-08 12:34:07.518	t
172	5	17:00:00	19:00:00	wednesday	walk-in	2025-05-08 12:34:07.518	2025-05-08 12:34:07.518	t
173	5	17:00:00	19:00:00	thursday	walk-in	2025-05-08 12:34:07.518	2025-05-08 12:34:07.518	t
174	5	17:00:00	19:00:00	friday	walk-in	2025-05-08 12:34:07.518	2025-05-08 12:34:07.518	t
175	5	17:00:00	19:00:00	saturday	walk-in	2025-05-08 12:34:07.518	2025-05-08 12:34:07.518	t
176	5	17:00:00	19:00:00	sunday	walk-in	2025-05-08 12:34:07.518	2025-05-08 12:34:07.518	t
185	5	14:00:00	15:00:00	monday	appointment	2025-05-08 12:35:52.63	2025-05-08 12:35:52.63	t
100	5	13:00:00	23:00:00	wednesday	walk-in	2025-05-05 14:37:14.119	2025-05-05 14:37:14.119	t
101	5	13:00:00	23:00:00	thursday	walk-in	2025-05-05 14:37:14.119	2025-05-05 14:37:14.119	t
102	5	13:00:00	23:00:00	friday	walk-in	2025-05-05 14:37:14.119	2025-05-05 14:37:14.119	t
103	5	13:00:00	23:00:00	saturday	walk-in	2025-05-05 14:37:14.119	2025-05-05 14:37:14.119	t
104	5	13:00:00	23:00:00	sunday	walk-in	2025-05-05 14:37:14.119	2025-05-05 14:37:14.119	t
105	5	00:00:00	00:00:00	monday	walk-in	2025-05-06 11:26:05.772	2025-05-06 11:26:05.772	t
106	5	00:00:00	00:00:00	monday	appointment	2025-05-06 11:26:10.123	2025-05-06 11:26:10.123	t
107	5	00:00:00	00:00:00	monday	walk-in	2025-05-06 11:26:17.067	2025-05-06 11:26:17.067	t
108	5	00:00:00	00:00:00	tuesday	walk-in	2025-05-06 11:26:17.067	2025-05-06 11:26:17.067	t
109	5	00:00:00	00:00:00	wednesday	walk-in	2025-05-06 11:26:17.067	2025-05-06 11:26:17.067	t
110	5	00:00:00	00:00:00	thursday	walk-in	2025-05-06 11:26:17.067	2025-05-06 11:26:17.067	t
161	5	21:00:00	22:00:00	wednesday	walk-in	2025-05-07 16:58:07.549	2025-05-07 16:58:07.549	t
111	5	00:00:00	00:00:00	friday	walk-in	2025-05-06 11:26:17.067	2025-05-06 11:26:17.067	t
112	5	00:00:00	00:00:00	saturday	walk-in	2025-05-06 11:26:17.067	2025-05-06 11:26:17.067	t
113	5	00:00:00	00:00:00	sunday	walk-in	2025-05-06 11:26:17.067	2025-05-06 11:26:17.067	t
114	5	11:00:00	13:00:00	monday	appointment	2025-05-06 11:33:34.839	2025-05-06 11:33:34.839	t
115	5	11:00:00	15:00:00	monday	appointment	2025-05-06 11:36:31.561	2025-05-06 11:36:31.561	t
116	5	11:00:00	15:00:00	tuesday	appointment	2025-05-06 11:36:31.561	2025-05-06 11:36:31.561	t
117	5	11:00:00	15:00:00	wednesday	appointment	2025-05-06 11:36:31.561	2025-05-06 11:36:31.561	t
118	5	11:00:00	15:00:00	thursday	appointment	2025-05-06 11:36:31.561	2025-05-06 11:36:31.561	t
119	5	11:00:00	15:00:00	friday	appointment	2025-05-06 11:36:31.561	2025-05-06 11:36:31.561	t
120	5	11:00:00	15:00:00	saturday	appointment	2025-05-06 11:36:31.561	2025-05-06 11:36:31.561	t
121	5	11:00:00	15:00:00	sunday	appointment	2025-05-06 11:36:31.561	2025-05-06 11:36:31.561	t
122	5	23:00:00	01:00:00	monday	walk-in	2025-05-06 11:36:44.334	2025-05-06 11:36:44.334	t
123	5	23:00:00	01:00:00	monday	walk-in	2025-05-06 11:36:56.601	2025-05-06 11:36:56.601	t
186	5	14:00:00	15:00:00	tuesday	appointment	2025-05-08 12:35:52.63	2025-05-08 12:35:52.63	t
187	5	14:00:00	15:00:00	wednesday	appointment	2025-05-08 12:35:52.63	2025-05-08 12:35:52.63	t
188	5	14:00:00	15:00:00	thursday	appointment	2025-05-08 12:35:52.63	2025-05-08 12:35:52.63	t
189	5	14:00:00	15:00:00	friday	appointment	2025-05-08 12:35:52.63	2025-05-08 12:35:52.63	t
190	5	14:00:00	15:00:00	saturday	appointment	2025-05-08 12:35:52.63	2025-05-08 12:35:52.63	t
191	5	14:00:00	15:00:00	sunday	appointment	2025-05-08 12:35:52.63	2025-05-08 12:35:52.63	t
192	5	15:00:00	19:00:00	monday	walk-in	2025-05-08 20:44:47.652	2025-05-08 20:44:47.652	f
193	5	15:00:00	19:00:00	tuesday	walk-in	2025-05-08 20:44:47.652	2025-05-08 20:44:47.652	f
194	5	15:00:00	19:00:00	wednesday	walk-in	2025-05-08 20:44:47.652	2025-05-08 20:44:47.652	f
195	5	15:00:00	19:00:00	thursday	walk-in	2025-05-08 20:44:47.652	2025-05-08 20:44:47.652	f
196	5	15:00:00	19:00:00	friday	walk-in	2025-05-08 20:44:47.652	2025-05-08 20:44:47.652	f
197	5	15:00:00	19:00:00	saturday	walk-in	2025-05-08 20:44:47.652	2025-05-08 20:44:47.652	f
198	5	15:00:00	19:00:00	sunday	walk-in	2025-05-08 20:44:47.652	2025-05-08 20:44:47.652	f
\.


--
-- TOC entry 2258 (class 0 OID 0)
-- Dependencies: 196
-- Name: doctor_schedule_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_schedule_id_seq', 198, true);


--
-- TOC entry 2208 (class 0 OID 23775)
-- Dependencies: 176
-- Data for Name: doctor_specialization; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor_specialization (id, doctor_id, specialization_id, created_at, updated_at) FROM stdin;
12	3	3	2025-04-11 09:44:45.728	2025-04-11 09:44:45.728
48	4	2	2025-04-14 16:27:46.542	2025-04-14 16:27:46.542
100	4	39	2025-04-22 11:03:08.997	2025-04-22 11:03:08.997
6	1	1	2025-04-11 09:44:21.272	2025-04-11 09:44:21.272
101	1	37	2025-04-22 11:04:22.556	2025-04-22 11:04:22.556
83	41	17	2025-04-22 10:56:24.898	2025-04-22 10:56:24.898
110	41	36	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
111	41	38	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
112	41	39	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
113	41	35	2025-04-27 14:44:44.669	2025-04-27 14:44:44.669
135	49	3	2025-04-27 22:45:31.572	2025-04-27 22:45:31.572
136	49	37	2025-04-27 22:45:31.572	2025-04-27 22:45:31.572
138	51	38	2025-04-29 11:26:19.072	2025-04-29 11:26:19.072
9	2	9	2025-04-11 09:44:32.462	2025-04-11 09:44:32.462
139	2	37	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
140	2	38	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
141	2	39	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
142	2	35	2025-04-29 11:48:50.681	2025-04-29 11:48:50.681
1	10	117	2025-04-10 14:31:50.161	2025-04-10 14:31:50.161
143	10	36	2025-05-05 00:15:27.942	2025-05-05 00:15:27.942
144	10	35	2025-05-05 00:15:27.942	2025-05-05 00:15:27.942
14	5	31	2025-04-11 09:44:55.376	2025-04-11 09:44:55.376
145	5	40	2025-05-08 20:48:25.588	2025-05-08 20:48:25.588
\.


--
-- TOC entry 2259 (class 0 OID 0)
-- Dependencies: 197
-- Name: doctor_specialization_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_specialization_id_seq', 145, true);


--
-- TOC entry 2211 (class 0 OID 23800)
-- Dependencies: 180
-- Data for Name: doctor_user_assign; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY doctor_user_assign (id, doctor_id, user_id) FROM stdin;
\.


--
-- TOC entry 2260 (class 0 OID 0)
-- Dependencies: 198
-- Name: doctor_user_assign_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('doctor_user_assign_id_seq', 1, false);


--
-- TOC entry 2209 (class 0 OID 23780)
-- Dependencies: 177
-- Data for Name: hmo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY hmo (id, name, description, created_at, updated_at, is_active, is_deleted) FROM stdin;
68	aaaa	aaa	2025-04-08 14:10:56.462	2025-04-08 14:39:54.863	1	t
69	aa	aaqweqwdqwdqw	2025-04-08 15:33:01.986	2025-04-08 15:33:01.986	1	t
4	AVEGA MANAGED CARE, INC.	Innovative healthcare management solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
5	BENEFICIAL LIFE INSURANCE CO., INC.	Trusted provider of life and health insurance.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
6	BRIGHTCARE ASSIST PHILS., INC.	Ensuring brighter healthcare solutions for all.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
7	BUPA INSURANCE SERVICES LIMITED	Global leader in healthcare insurance and protection.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
8	CAREHEALTH	Dedicated to delivering quality healthcare services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
9	CAREHEALTH PLUS SYSTEMS INTL., INC.	Innovative health management system for Filipinos.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
10	CARITAS HEALTH SHIELD INC	Committed to providing comprehensive health protection.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
11	CIGNA	Worldwide provider of health insurance solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
12	COCOLIFE HEALTHCARE	Offering comprehensive life and health plans.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
13	COOPERATIVE HEALTH MANAGEMENT FEDERATION	Promoting health and well-being through cooperative management.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
14	EASTWEST HEALTHCARE INC.	Providing integrated healthcare services nationwide.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
15	EIQA	Empowering quality and affordable healthcare.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
16	ELITE GROUP	Exclusive healthcare solutions for elite clients.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
17	ETIQA LIFE AND GENERAL ASSURANCE PHILS., INC.	Providing life and general insurance services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
18	FORTICARE HEALTH SYSTEMS INTERNATIONAL, INC.	Delivering high-quality health systems globally.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
19	FORTUNE MEDICARE INC.	Affordable and reliable healthcare services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
20	GAIN HEALTH CARE INC.	Helping members gain access to quality care.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
21	GENERALI PILIPINAS	Part of the global Generali Group offering health and life insurance.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
22	GETWELL HEALTH SYSTEMS, INC.	Ensuring better healthcare access for everyone.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
23	HEALTH DELIVERY SYSTEMS, INC. (FLEXICARE)	Flexible healthcare solutions and systems.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
24	HEALTH MAINTENANCE INC.	Maintaining the health and wellness of its members.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
25	HEALTH PLAN PHILS., INC.	Providing flexible and reliable health plans.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
26	HEALTHCARE	Committed to promoting better healthcare solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
27	HEALTHCARE PLUS	Enhancing healthcare services for better well-being.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
28	HEALTHWAY MEDI-ACCESS	Delivering accessible and reliable healthcare services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
29	HMI	Committed to healthcare excellence and innovation.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
30	HPPI	Ensuring health protection and insurance services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
31	ICARE	Caring for your health with compassion and quality.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
32	IMS WELLTHCARE, INC.	Integrated healthcare management solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
33	INLIFE	Innovative life and healthcare solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
34	INSULAR LIFE HEALTHCARE	Trusted name in life and health insurance.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
35	INTELLICARE (ASALUS CORP)	Intelligent healthcare solutions for modern needs.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
36	INTELLICARE MEDICARD	Combining healthcare and insurance expertise.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
37	KAISER INTERNATIONAL	Reliable international healthcare services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
38	LACSON & LACSON	Providing tailored healthcare solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
39	LIFE AND HEALTH, HMP INC.	Promoting better life and health management.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
40	MARINE	Healthcare solutions for maritime professionals.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
41	MAXICARE HEALTHCARE CORP.	Philippines’ leading HMO with extensive network coverage.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
42	MEDASIA PHILIPPINES	Innovative medical assistance and healthcare solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
43	MEDICARD ETTIQA	Offering comprehensive health management solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
44	MEDICARD PHILIPPINES, INC.	Ensuring quality healthcare for Filipinos.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
45	MEDICARE PLUS	Affordable and accessible healthcare for all.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
46	MEDILINK	Bridging technology and healthcare services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
47	MEDOCARE HEALTH SYSTEMS INC.	Delivering reliable healthcare systems.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
48	MERALCO	Healthcare services for Meralco employees and affiliates.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
49	METROCARE HEALTH SYSTEMS INC.	Focusing on high-quality and efficient health services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
50	MICARE HEALTH INSURANCE PLAN	Providing micro-health insurance solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
51	MMS	Innovative healthcare and wellness management.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
52	NETCARE LIFE & HEALTH INSURANCE CO.	Comprehensive life and health insurance.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
53	OPTIMUM MEDICAL AND HEALTHCARE SERVICES, INC.	Delivering optimal healthcare solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
54	PACIFIC CROSS HEALTHCARE, INC.	Leading provider of international health insurance.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
55	PAG-COR	Providing healthcare support to employees and affiliates.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
56	PAL	Health benefits for Philippine Airlines employees.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
57	PHILCARE	Pioneering HMO services with extensive coverage.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
58	PHILIPPINE BRITISH ASSURANCE COMPANY	Providing health and life insurance.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
59	PLDT	Healthcare services for PLDT employees and affiliates.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
60	SELECTCARE PHILS. INC	Customized healthcare plans for various needs.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
61	STAR HEALTHCARE/ BENLIFE	Trusted health and life insurance services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
62	STAY WELL INFORMATION SYSTEMS	Delivering innovative health information systems.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
63	SUN LIFE GREPA FINANCIAL, INC./GREPALIFE	Combining financial and healthcare solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
64	TAKECARE ASIA PHILS., INC.	Providing trusted healthcare for Asia-Pacific clients.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
65	UNITEDHEALTHCARE INTERNATIONAL, INC.	Global leader in healthcare services.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
66	VALUCARE HEALTH SYSTEM, INC.	Delivering value-driven healthcare solutions.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	f
70	AADQW WQDQWDQW QWD DQWDQWDQW	qwdqw	2025-04-08 15:42:42.877	2025-04-08 15:42:42.877	1	t
71	Aaa	aaa	2025-04-09 12:38:56.896	2025-04-09 12:39:05.736	1	t
72	AAAAAA	aA aA  aa  a	2025-04-09 18:32:45.706	2025-04-09 18:33:07.928	1	t
1	ADVANCED MEDICAL ACCESS PHILIPPINES, INC.	Providing accessible and quality healthcare services in the Philippines.	2025-03-28 09:26:58.737	2025-04-10 10:39:52.487	1	f
3	ASIAN LIFE	Comprehensive life and health insurance services.	2025-03-28 09:26:58.737	2025-04-10 15:17:54.776	1	f
2	AMAPHIL	Affordable medical assistance and healthcare coverage.	2025-03-28 09:26:58.737	2025-03-28 09:26:58.737	1	t
67	WELLCARE HEALTH MAINTENANCE, INCORPORATED	Ensuring well-maintained health services.	2025-03-28 09:26:58.737	2025-04-24 14:00:20.739	1	f
\.


--
-- TOC entry 2261 (class 0 OID 0)
-- Dependencies: 199
-- Name: hmo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('hmo_id_seq', 72, true);


--
-- TOC entry 2224 (class 0 OID 23884)
-- Dependencies: 202
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY migrations (id, migration, batch) FROM stdin;
\.


--
-- TOC entry 2262 (class 0 OID 0)
-- Dependencies: 203
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('migrations_id_seq', 1, false);


--
-- TOC entry 2210 (class 0 OID 23789)
-- Dependencies: 178
-- Data for Name: specialization; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY specialization (id, name, type, is_active, created_at, updated_at, is_deleted) FROM stdin;
1	ADULT CARDIOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
2	ANATOMIC & CLINICAL PATHOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
3	ANATOMIC PATHOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
4	ANESTHESIOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
5	ANESTHESIOLOGY AND PAIN MEDICINE	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
6	CARDINAL SANTOS KIDNEY CARE CENTER	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
7	CARDIOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
8	CLINICAL PATHOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
9	DENTAL MEDICINE	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
10	EMERGENCY MEDICINE	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
11	GENERAL OB GYN	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
12	GENERAL OBGYN	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
13	GENERAL OPHTHALMOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
14	GENERAL SURGERY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
15	INTERNAL MEDICINE	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
16	MINIMALLY INVASIVE SURGERY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
17	NEPHROLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
18	NEUROLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
19	NUCLEAR MEDICINE	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
20	OBSTETRICS & GYN	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
21	OBSTETRICS & GYNECOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
22	OFFICE OF THE CMO	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
23	OPHTHALMOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
24	ORTHOPEDICS	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
25	OTHERS	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
26	PATHOLOGY & LABORATORY SERVICES	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
27	PEDIATRICS	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
28	PSYCHOLOGY AND MENTAL HEALTH WELLNESS	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
29	RADIATION ONCOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
30	RADIOLOGY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
31	REHABILITATION MEDICINE	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
32	SURGERY	master	1	2025-03-28 00:07:43.438	2025-03-28 00:07:43.438	f
36	ANATOMIC & CLINICAL PATHOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
37	ANATOMIC PATHOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
38	ANESTHESIA	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
39	ANESTHESIOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
40	ANESTHESIOLOGY AND PAIN MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
41	BARIATRIC SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
42	BREAST SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
43	CARDIAC SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
44	CARDIOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
45	CARDIOVASCULAR SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
46	CLINICAL PATHOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
47	COLORECTAL SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
48	DENTAL MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
49	DERMATOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
50	DIAGNOSTIC RADIOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
51	EMERGENCY MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
52	ENDOCRINOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
53	ENDOCRINOLOGY AND METABOLISM	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
54	ENDOUROLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
55	ENT	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
56	FAMILY MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
57	GASTROENTEROLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
58	GENERAL OB GYN	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
59	GENERAL OBGYN	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
60	GENERAL OPHTHALMOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
61	GENERAL PEDIATRICS	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
62	GENERAL SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
63	GERIATRICS	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
64	GYNECOLOGIC ONCOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
65	HEMATOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
66	INFECTIOUS DISEASE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
67	INTERVENTIONAL CARDIOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
68	INTERVENTIONAL RADIOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
69	INTERNAL MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
70	MATERNAL & FETAL MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
71	MINIMALLY INVASIVE SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
72	NEONATOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
73	NEPHROLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
74	NEUROLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
75	NEUROSURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
76	NUCLEAR MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
77	OBSTETRICS & GYN	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
78	OBSTETRICS & GYNECOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
79	OFFICE OF THE CMO	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
80	ONCOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
81	OPHTHALMOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
82	ORTHOPEDIC SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
83	ORTHOPEDICS	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
84	OTHERS	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
85	OTORHINOLARYNGOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
86	PATHOLOGY & LABORATORY SERVICES	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
87	PEDIATRIC CARDIOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
88	PEDIATRIC HEMATOLOGY ONCOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
89	PEDIATRIC NEPHROLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
90	PEDIATRIC PULMONOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
91	PEDIATRICS	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
92	PLASTIC AND RECONSTRUCTIVE SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
93	PODIATRY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
94	PULMONOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
95	PSYCHIATRY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
96	PSYCHOLOGY AND MENTAL HEALTH WELLNESS	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
34	AAA	master	0	2025-04-10 13:34:09.276	2025-04-10 13:34:09.276	t
97	RADIATION ONCOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
98	RADIOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
99	REHABILITATION MEDICINE	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
100	REPRODUCTIVE ENDOCRINOLOGY AND INFERTILITY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
101	RHEUMATOLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
102	SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
103	THORACIC SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
104	UROLOGY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
105	VASCULAR SURGERY	sub	1	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	f
33	A	sub	0	2025-04-10 12:09:04.545	2025-04-10 17:02:01.16	t
106	AA	sub	1	2025-04-10 12:09:12.024	2025-04-10 12:09:12.024	t
107	AAAAA	master	0	2025-04-24 13:48:03.245	2025-04-24 13:49:12.587	t
108	AAAAAAAAAAA	master	1	2025-04-27 12:07:51.36	2025-04-27 12:07:51.36	t
109	AAAAAAAAAa	master	1	2025-04-27 12:44:01.945	2025-04-27 12:45:01.692	t
110	AAAAAAAAAAA	master	1	2025-04-27 12:46:08.462	2025-04-27 12:48:56.144	t
111	AAAAAAAAA	master	1	2025-04-27 13:57:37.044	2025-04-27 13:57:37.044	t
113	AAAAAAAA	master	1	2025-04-27 13:59:26.226	2025-04-27 13:59:26.226	t
112	AAAAAA	master	1	2025-04-27 13:58:13.711	2025-04-27 13:58:13.711	t
115	AAAAAAAAAAAAAA	sub	0	2025-04-27 14:39:04.896	2025-04-27 14:39:04.896	t
35	AAAAAAAA	sub	0	2025-03-28 00:11:53.58	2025-04-27 14:38:17.559	t
114	AAAAAAAAAAAA	master	1	2025-04-27 14:38:56.513	2025-04-27 14:38:56.513	t
117	PRIMARY CARE	master	1	2025-05-04 23:59:35.472	2025-05-04 23:59:35.472	f
116	ABBBBB	master	1	2025-04-29 15:47:47.48	2025-04-29 15:48:02.913	t
\.


--
-- TOC entry 2263 (class 0 OID 0)
-- Dependencies: 205
-- Name: specialization_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('specialization_id_seq', 117, true);


--
-- TOC entry 2227 (class 0 OID 23895)
-- Dependencies: 206
-- Data for Name: sub_specialization; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sub_specialization (id, name, created_at, updated_at, is_active) FROM stdin;
72	ADULT CARDIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
73	ANATOMIC & CLINICAL PATHOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
74	ANATOMIC PATHOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
75	ANESTHESIA	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
76	ANESTHESIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
77	ANESTHESIOLOGY AND PAIN MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
78	BARIATRIC SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
79	BREAST SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
80	CARDIAC SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
81	CARDIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
82	CARDIOVASCULAR SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
83	CLINICAL PATHOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
84	COLORECTAL SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
85	DENTAL MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
86	DERMATOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
87	DIAGNOSTIC RADIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
88	EMERGENCY MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
89	ENDOCRINOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
90	ENDOCRINOLOGY AND METABOLISM	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
91	ENDOUROLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
92	ENT	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
93	FAMILY MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
94	GASTROENTEROLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
95	GENERAL OB GYN	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
96	GENERAL OBGYN	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
97	GENERAL OPHTHALMOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
98	GENERAL PEDIATRICS	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
99	GENERAL SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
100	GERIATRICS	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
101	GYNECOLOGIC ONCOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
102	HEMATOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
103	INFECTIOUS DISEASE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
104	INTERVENTIONAL CARDIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
105	INTERVENTIONAL RADIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
106	INTERNAL MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
107	MATERNAL & FETAL MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
108	MINIMALLY INVASIVE SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
109	NEONATOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
110	NEPHROLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
111	NEUROLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
112	NEUROSURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
113	NUCLEAR MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
114	OBSTETRICS & GYN	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
115	OBSTETRICS & GYNECOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
116	OFFICE OF THE CMO	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
117	ONCOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
118	OPHTHALMOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
119	ORTHOPEDIC SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
120	ORTHOPEDICS	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
121	OTHERS	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
122	OTORHINOLARYNGOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
123	PATHOLOGY & LABORATORY SERVICES	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
124	PEDIATRIC CARDIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
125	PEDIATRIC HEMATOLOGY ONCOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
126	PEDIATRIC NEPHROLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
127	PEDIATRIC PULMONOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
128	PEDIATRICS	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
129	PLASTIC AND RECONSTRUCTIVE SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
130	PODIATRY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
131	PULMONOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
132	PSYCHIATRY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
133	PSYCHOLOGY AND MENTAL HEALTH WELLNESS	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
134	RADIATION ONCOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
135	RADIOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
136	REHABILITATION MEDICINE	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
137	REPRODUCTIVE ENDOCRINOLOGY AND INFERTILITY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
138	RHEUMATOLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
139	SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
140	THORACIC SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
141	UROLOGY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
142	VASCULAR SURGERY	2025-03-28 00:11:53.58	2025-03-28 00:11:53.58	1
143	AA	2025-04-10 12:09:12.024	2025-04-10 12:09:12.024	1
144	AAA	2025-04-10 16:52:29.933	2025-04-10 16:52:29.933	1
\.


--
-- TOC entry 2264 (class 0 OID 0)
-- Dependencies: 207
-- Name: sub_specialization_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('sub_specialization_id_seq', 144, true);


--
-- TOC entry 2212 (class 0 OID 23803)
-- Dependencies: 181
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (id, username, email, password, remember_token, created_at, updated_at, role_type, is_disabled, is_deleted, last_password_changed) FROM stdin;
2	secre	pass.num.2015@gmail.com	321	\N	2025-04-19 12:45:54	2025-04-19 12:45:54	secretary	0	f	\N
13	asdsadasdsa		\N	\N	2025-04-30 16:20:17.426	2025-04-30 16:20:17.426	secretary	0	t	\N
12	dqwqdwqwdqwdwq	pass.num.2015@gmail.com	\N	\N	2025-04-30 14:46:52.369	2025-04-30 14:46:52.369	secretary	0	t	\N
14	aaaaaaaaaaaaaaaaaa		\N	\N	2025-04-30 17:22:54.226	2025-04-30 17:25:52.187	secretary	0	t	\N
1	mmaeee	mearcoangelo.quanico@gmail.com	123	\N	2025-04-19 17:46:44.417	2025-04-30 16:35:43.58	secretary	0	f	\N
15	aaaqwqdwdqw		\N	\N	2025-04-30 17:26:04.063	2025-04-30 17:27:30.029	secretary	1	t	\N
3	geloquan	pass.num@gmail.com	123	\N	2025-04-19 12:47:03	2025-04-30 17:57:36.344	master	0	f	\N
7	atdogs	meow.quanico@gmail.com	\N	\N	2025-04-30 14:32:51.559	2025-04-30 18:02:53.42	master	1	f	\N
\.


--
-- TOC entry 2265 (class 0 OID 0)
-- Dependencies: 209
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 15, true);


--
-- TOC entry 2037 (class 2606 OID 23924)
-- Name: advertisement_schedule_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY advertisement_schedule
    ADD CONSTRAINT advertisement_schedule_pkey PRIMARY KEY (id);


--
-- TOC entry 2041 (class 2606 OID 23926)
-- Name: doctor_busy_schedule_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_busy_schedule
    ADD CONSTRAINT doctor_busy_schedule_pkey PRIMARY KEY (id);


--
-- TOC entry 2043 (class 2606 OID 23928)
-- Name: doctor_clinic_doctor_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_clinic
    ADD CONSTRAINT doctor_clinic_doctor_id_key UNIQUE (doctor_id);


--
-- TOC entry 2045 (class 2606 OID 23930)
-- Name: doctor_clinic_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_clinic
    ADD CONSTRAINT doctor_clinic_pkey PRIMARY KEY (id);


--
-- TOC entry 2047 (class 2606 OID 23932)
-- Name: doctor_hmo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_hmo
    ADD CONSTRAINT doctor_hmo_pkey PRIMARY KEY (id);


--
-- TOC entry 2039 (class 2606 OID 23934)
-- Name: doctor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor
    ADD CONSTRAINT doctor_pkey PRIMARY KEY (id);


--
-- TOC entry 2066 (class 2606 OID 23936)
-- Name: doctor_queue_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_queue
    ADD CONSTRAINT doctor_queue_pkey PRIMARY KEY (id);


--
-- TOC entry 2049 (class 2606 OID 23938)
-- Name: doctor_schedule_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_schedule
    ADD CONSTRAINT doctor_schedule_pkey PRIMARY KEY (id);


--
-- TOC entry 2051 (class 2606 OID 23940)
-- Name: doctor_specialization_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_specialization
    ADD CONSTRAINT doctor_specialization_pkey PRIMARY KEY (id);


--
-- TOC entry 2060 (class 2606 OID 23942)
-- Name: doctor_user_assign_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY doctor_user_assign
    ADD CONSTRAINT doctor_user_assign_pkey PRIMARY KEY (id);


--
-- TOC entry 2070 (class 2606 OID 23944)
-- Name: fk_master_specialization_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sub_specialization
    ADD CONSTRAINT fk_master_specialization_id PRIMARY KEY (id);


--
-- TOC entry 2054 (class 2606 OID 23946)
-- Name: hmo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hmo
    ADD CONSTRAINT hmo_pkey PRIMARY KEY (id);


--
-- TOC entry 2068 (class 2606 OID 23948)
-- Name: migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 2058 (class 2606 OID 23950)
-- Name: specialization_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY specialization
    ADD CONSTRAINT specialization_pkey PRIMARY KEY (id);


--
-- TOC entry 2062 (class 2606 OID 23952)
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2064 (class 2606 OID 23954)
-- Name: users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- TOC entry 2055 (class 1259 OID 23955)
-- Name: idx_specialization_name; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_specialization_name ON specialization USING btree (name);


--
-- TOC entry 2056 (class 1259 OID 23956)
-- Name: idx_specialization_type; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_specialization_type ON specialization USING btree (type);


--
-- TOC entry 2052 (class 1259 OID 23957)
-- Name: only_one_master_specialization; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX only_one_master_specialization ON doctor_specialization USING btree (doctor_id) WHERE is_master_specialization(specialization_id);


--
-- TOC entry 2200 (class 2618 OID 23958)
-- Name: _RETURN; Type: RULE; Schema: public; Owner: postgres
--

CREATE RULE "_RETURN" AS ON SELECT TO doctor_resource DO INSTEAD SELECT d.id AS doctor_id, d.first_name, d.middle_name, d.last_name, d.contact_number AS doctor_contact_number, d.suffix AS doctor_suffix, d.image_path, dc.code_name AS clinic_code_name, (SELECT sp_master.name FROM (doctor_specialization dsp_master JOIN specialization sp_master ON ((dsp_master.specialization_id = sp_master.id))) WHERE ((dsp_master.doctor_id = d.id) AND (sp_master.type = 'master'::specialization_type)) LIMIT 1) AS master_specialization, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT sp_sub.name FROM (doctor_specialization dsp_sub JOIN specialization sp_sub ON ((dsp_sub.specialization_id = sp_sub.id))) WHERE ((dsp_sub.doctor_id = d.id) AND (sp_sub.type <> 'master'::specialization_type))) specs), '[]'::json) AS sub_specialization, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT ds_inner.day_of_week FROM (doctor_schedule ds_inner LEFT JOIN doctor_busy_schedule dbsch ON ((ds_inner.doctor_id = dbsch.doctor_id))) WHERE (((ds_inner.doctor_id = d.id) AND (ds_inner.is_deleted = false)) AND (NOT (EXISTS (SELECT 1 FROM doctor_busy_schedule dbsch2 WHERE ((((dbsch2.doctor_id = ds_inner.doctor_id) AND (dbsch2.start_datetime >= ('now'::text)::date)) AND (dbsch2.end_datetime <= (('now'::text)::date + '6 days'::interval))) AND (btrim(lower(to_char(dbsch2.start_datetime, 'day'::text))) = (ds_inner.day_of_week)::text))))))) specs), '[]'::json) AS day_of_week, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT DISTINCT h_inner.name FROM (doctor_hmo dh_inner LEFT JOIN hmo h_inner ON ((dh_inner.hmo_id = h_inner.id))) WHERE (dh_inner.doctor_id = d.id) ORDER BY h_inner.name) specs), '[]'::json) AS doctor_hmo, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT ds_inner.id, ds_inner.start_time, ds_inner.end_time, ds_inner.day_of_week, ds_inner.visit_type FROM doctor_schedule ds_inner WHERE (((ds_inner.doctor_id = d.id) AND (ds_inner.is_deleted = false)) AND (NOT (EXISTS (SELECT 1 FROM doctor_busy_schedule dbsch2 WHERE ((((dbsch2.doctor_id = ds_inner.doctor_id) AND (dbsch2.start_datetime >= ('now'::text)::date)) AND (dbsch2.end_datetime <= (('now'::text)::date + '6 days'::interval))) AND (btrim(lower(to_char(dbsch2.start_datetime, 'day'::text))) = (ds_inner.day_of_week)::text))))))) specs), '[]'::json) AS schedule, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT dbs_inner.id, dbs_inner.start_datetime, dbs_inner.end_datetime FROM doctor_busy_schedule dbs_inner WHERE ((dbs_inner.doctor_id = d.id) AND (dbs_inner.is_deleted = false))) specs), '[]'::json) AS schedule_busy, COALESCE((SELECT array_to_json(array_agg(row_to_json(specs.*))) AS array_to_json FROM (SELECT s_inner.id, s_inner.name, s_inner.type FROM (doctor_specialization dsp_inner LEFT JOIN specialization s_inner ON ((dsp_inner.specialization_id = s_inner.id))) WHERE (dsp_inner.doctor_id = d.id)) specs), '[]'::json) AS specializations FROM (((((((doctor d LEFT JOIN doctor_hmo dh ON (((d.id = dh.doctor_id) AND (dh.is_active = 1)))) LEFT JOIN doctor_schedule ds ON ((d.id = ds.doctor_id))) LEFT JOIN doctor_busy_schedule dbs ON ((d.id = dbs.doctor_id))) LEFT JOIN doctor_clinic dc ON ((d.id = dc.doctor_id))) LEFT JOIN doctor_specialization dsp ON ((d.id = dsp.doctor_id))) LEFT JOIN specialization sp ON ((dsp.specialization_id = sp.id))) LEFT JOIN hmo h ON ((dh.hmo_id = h.id))) WHERE ((((d.is_active = 1) AND (d.is_deleted = false)) AND (sp.is_active = 1)) AND (sp.is_deleted = false)) GROUP BY d.id, dc.code_name;


--
-- TOC entry 2072 (class 2606 OID 23960)
-- Name: fk_doctor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_clinic
    ADD CONSTRAINT fk_doctor FOREIGN KEY (doctor_id) REFERENCES doctor(id);


--
-- TOC entry 2073 (class 2606 OID 23965)
-- Name: fk_doctor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_hmo
    ADD CONSTRAINT fk_doctor FOREIGN KEY (doctor_id) REFERENCES doctor(id);


--
-- TOC entry 2075 (class 2606 OID 23970)
-- Name: fk_doctor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_schedule
    ADD CONSTRAINT fk_doctor FOREIGN KEY (doctor_id) REFERENCES doctor(id);


--
-- TOC entry 2076 (class 2606 OID 23975)
-- Name: fk_doctor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_specialization
    ADD CONSTRAINT fk_doctor FOREIGN KEY (doctor_id) REFERENCES doctor(id);


--
-- TOC entry 2078 (class 2606 OID 23980)
-- Name: fk_doctor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_user_assign
    ADD CONSTRAINT fk_doctor FOREIGN KEY (doctor_id) REFERENCES doctor(id);


--
-- TOC entry 2080 (class 2606 OID 23985)
-- Name: fk_doctor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_queue
    ADD CONSTRAINT fk_doctor FOREIGN KEY (doctor_id) REFERENCES doctor(id);


--
-- TOC entry 2071 (class 2606 OID 23990)
-- Name: fk_doctor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_busy_schedule
    ADD CONSTRAINT fk_doctor FOREIGN KEY (doctor_id) REFERENCES doctor(id);


--
-- TOC entry 2074 (class 2606 OID 23995)
-- Name: fk_hmo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_hmo
    ADD CONSTRAINT fk_hmo FOREIGN KEY (hmo_id) REFERENCES hmo(id);


--
-- TOC entry 2079 (class 2606 OID 24000)
-- Name: fk_hmo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_user_assign
    ADD CONSTRAINT fk_hmo FOREIGN KEY (user_id) REFERENCES users(id);


--
-- TOC entry 2077 (class 2606 OID 24005)
-- Name: fk_specialization; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_specialization
    ADD CONSTRAINT fk_specialization FOREIGN KEY (specialization_id) REFERENCES specialization(id);


--
-- TOC entry 2081 (class 2606 OID 24010)
-- Name: fk_specialization; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY doctor_queue
    ADD CONSTRAINT fk_specialization FOREIGN KEY (specialization_id) REFERENCES specialization(id);


--
-- TOC entry 2236 (class 0 OID 0)
-- Dependencies: 7
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2025-05-20 14:12:07

--
-- PostgreSQL database dump complete
--

