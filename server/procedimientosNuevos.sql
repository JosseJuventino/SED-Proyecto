--
-- PostgreSQL database dump
--

-- Dumped from database version 14.13 (Ubuntu 14.13-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.13 (Ubuntu 14.13-0ubuntu0.22.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: crear_apuesta(integer, numeric, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.crear_apuesta(user_id integer, cantidad numeric, idestadoapuesta integer, idpartido integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    user_role VARCHAR;
BEGIN
    -- Obtener el rol del usuario
    SELECT get_user_role(user_id) INTO user_role;

    -- Validar rol permitido
    IF user_role IN ('usuario', 'admin', 'superadmin') THEN
        INSERT INTO apuestas (idusuario, cantidadapostada, fechaapuesta, idestadoapuesta, idpartido)
        VALUES (user_id, cantidad, CURRENT_DATE, idestadoapuesta, idpartido);
    ELSE
        RAISE EXCEPTION 'Permiso denegado';
    END IF;
END;
$$;


ALTER FUNCTION public.crear_apuesta(user_id integer, cantidad numeric, idestadoapuesta integer, idpartido integer) OWNER TO postgres;

--
-- Name: crear_equipo(integer, character varying, character varying, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.crear_equipo(user_id integer, nombre character varying, representante character varying, fecha date) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    user_role VARCHAR;
BEGIN
    -- Obtener el rol del usuario
    SELECT get_user_role(user_id) INTO user_role;

    -- Validar rol permitido
    IF user_role IN ('admin', 'superadmin') THEN
        INSERT INTO equipos (nombreequipo, representanteequipo, fechafundacion)
        VALUES (nombre, representante, fecha);
    ELSE
        RAISE EXCEPTION 'Permiso denegado';
    END IF;
END;
$$;


ALTER FUNCTION public.crear_equipo(user_id integer, nombre character varying, representante character varying, fecha date) OWNER TO postgres;

--
-- Name: crear_partido(integer, date, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.crear_partido(user_id integer, fecha date, marcadorlocal integer, marcadorvisitante integer, idequipolocal integer, idequipovisitante integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    user_role VARCHAR;
BEGIN
    -- Obtener el rol del usuario
    SELECT get_user_role(user_id) INTO user_role;

    -- Validar rol permitido
    IF user_role IN ('admin', 'superadmin') THEN
        INSERT INTO partido (fechapartido, marcadorlocal, marcadorvisitante, idequipolocal, idequipovisitante)
        VALUES (fecha, marcadorlocal, marcadorvisitante, idequipolocal, idequipovisitante);
    ELSE
        RAISE EXCEPTION 'Permiso denegado';
    END IF;
END;
$$;


ALTER FUNCTION public.crear_partido(user_id integer, fecha date, marcadorlocal integer, marcadorvisitante integer, idequipolocal integer, idequipovisitante integer) OWNER TO postgres;

--
-- Name: create_apuesta(integer, numeric, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_apuesta(usuarioid integer, cantidad numeric, estadoapuestaid integer, partidoid integer) RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    INSERT INTO apuestas (idusuario, cantidadapostada, idestadoapuesta, idpartido)
    VALUES (usuarioId, cantidad, estadoApuestaId, partidoId)
    RETURNING
        apuestas.idapuestas AS idApuestas,
        apuestas.idusuario AS idUsuario,
        apuestas.cantidadapostada AS cantidadApostada,
        apuestas.fechaapuesta AS fechaApuesta,
        apuestas.idestadoapuesta AS idEstadoApuesta,
        apuestas.idpartido AS idPartido;
END;
$$;


ALTER FUNCTION public.create_apuesta(usuarioid integer, cantidad numeric, estadoapuestaid integer, partidoid integer) OWNER TO postgres;

--
-- Name: create_apuesta(integer, numeric, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_apuesta(p_idusuario integer, p_cantidadapostada numeric, p_idestadoapuesta integer, p_idpartido integer, p_golequipolocal integer, p_golequipovisitante integer) RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer, golequipolocal integer, golequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    INSERT INTO public.apuestas (
        idusuario, cantidadapostada, fechaapuesta, idestadoapuesta, idpartido, golequipolocal, golequipovisitante
    ) VALUES (
        p_idUsuario, p_cantidadApostada, CURRENT_DATE, p_idEstadoApuesta, p_idPartido, p_golEquipoLocal, p_golEquipoVisitante
    )
    RETURNING *;
END;
$$;


ALTER FUNCTION public.create_apuesta(p_idusuario integer, p_cantidadapostada numeric, p_idestadoapuesta integer, p_idpartido integer, p_golequipolocal integer, p_golequipovisitante integer) OWNER TO postgres;

--
-- Name: create_equipo(text, text, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_equipo(nombre text, representante text, fecha date) RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    INSERT INTO equipos (nombreequipo, representanteequipo, fechafundacion)
    VALUES (nombre, representante, COALESCE(fecha, CURRENT_DATE))
    RETURNING
        equipos.idequipo AS idEquipo,
        equipos.nombreequipo AS nombreEquipo,
        equipos.representanteequipo AS representanteEquipo,
        equipos.fechafundacion AS fechaFundacion;
END;
$$;


ALTER FUNCTION public.create_equipo(nombre text, representante text, fecha date) OWNER TO postgres;

--
-- Name: create_equipo(character varying, character varying, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_equipo(nombre character varying, representante character varying, fecha date) RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    INSERT INTO equipos (nombreequipo, representanteequipo, fechafundacion)
    VALUES (nombre, representante, COALESCE(fecha, CURRENT_DATE))
    RETURNING
        idequipo AS idEquipo,
        nombreequipo AS nombreEquipo,
        representanteequipo AS representanteEquipo,
        fechafundacion AS fechaFundacion;
END;
$$;


ALTER FUNCTION public.create_equipo(nombre character varying, representante character varying, fecha date) OWNER TO postgres;

--
-- Name: create_partido(date, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_partido(param_fecha date, param_marcadorlocal integer, param_marcadorvisitante integer, param_equipolocalid integer, param_equipovisitanteid integer) RETURNS TABLE(idpartido integer, fechapartido date, marcadorlocal integer, marcadorvisitante integer, idequipolocal integer, idequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    INSERT INTO partido (fechapartido, marcadorlocal, marcadorvisitante, idequipolocal, idequipovisitante)
    VALUES (param_fecha, param_marcadorLocal, param_marcadorVisitante, param_equipoLocalId, param_equipoVisitanteId)
    RETURNING partido.idpartido AS idPartido, 
              partido.fechapartido AS fechaPartido, 
              partido.marcadorlocal AS marcadorLocal, 
              partido.marcadorvisitante AS marcadorVisitante, 
              partido.idequipolocal AS idEquipoLocal, 
              partido.idequipovisitante AS idEquipoVisitante;
END;
$$;


ALTER FUNCTION public.create_partido(param_fecha date, param_marcadorlocal integer, param_marcadorvisitante integer, param_equipolocalid integer, param_equipovisitanteid integer) OWNER TO postgres;

--
-- Name: create_user(text, text, text, text, text, text, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_user(nombre text, apellido text, dui text, correo text, usuario text, clave text, rol integer, puntos integer DEFAULT 0) RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying, email character varying, username character varying, puntosuser integer, idrol integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    INSERT INTO Usuarios (nombreusuario, apellidousuario, dui, email, username, clave, puntosuser, idrol)
    VALUES (nombre, apellido, dui, correo, usuario, clave, puntos, rol)
    RETURNING Usuarios.idusuario AS idUsuario, 
              Usuarios.nombreusuario AS nombreUsuario, 
              Usuarios.apellidousuario AS apellidoUsuario, 
              Usuarios.email AS email, 
              Usuarios.username AS userName, 
              Usuarios.puntosuser AS puntosUser, 
              Usuarios.idrol AS idRol;
END;
$$;


ALTER FUNCTION public.create_user(nombre text, apellido text, dui text, correo text, usuario text, clave text, rol integer, puntos integer) OWNER TO postgres;

--
-- Name: create_user(character varying, character varying, character varying, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_user(nombre character varying, apellido character varying, dui character varying, correo character varying, usuario character varying, clave character varying, rol integer, puntos integer DEFAULT 0) RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying, email character varying, username character varying, puntosuser integer, idrol integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO Usuarios (nombreusuario, apellidousuario, dui, email, username, clave, puntosuser, idrol)
    VALUES (nombre, apellido, dui, correo, usuario, clave, puntos, rol)
    RETURNING idusuario, nombreusuario, apellidousuario, email, username, puntosuser, idrol;
END;
$$;


ALTER FUNCTION public.create_user(nombre character varying, apellido character varying, dui character varying, correo character varying, usuario character varying, clave character varying, rol integer, puntos integer) OWNER TO postgres;

--
-- Name: delete_apuesta(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.delete_apuesta(apuestaid integer) RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    DELETE FROM apuestas
    WHERE apuestas.idapuestas = apuestaId -- Se especifica "apuestas.idapuestas" para evitar ambigüedad
    RETURNING
        apuestas.idapuestas AS idApuestas,
        apuestas.idusuario AS idUsuario,
        apuestas.cantidadapostada AS cantidadApostada,
        apuestas.fechaapuesta AS fechaApuesta,
        apuestas.idestadoapuesta AS idEstadoApuesta,
        apuestas.idpartido AS idPartido;
END;
$$;


ALTER FUNCTION public.delete_apuesta(apuestaid integer) OWNER TO postgres;

--
-- Name: delete_equipo(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.delete_equipo(equipoid integer) RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    DELETE FROM equipos e -- Usamos un alias explícito "e"
    WHERE e.idequipo = equipoId -- Alias explícito aquí
    RETURNING
        e.idequipo AS idEquipo,
        e.nombreequipo AS nombreEquipo,
        e.representanteequipo AS representanteEquipo,
        e.fechafundacion AS fechaFundacion;
END;
$$;


ALTER FUNCTION public.delete_equipo(equipoid integer) OWNER TO postgres;

--
-- Name: delete_partido(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.delete_partido(partidoid integer) RETURNS TABLE(idpartido integer, fechapartido date, marcadorlocal integer, marcadorvisitante integer, idequipolocal integer, idequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    DELETE FROM partido
    WHERE partido.idpartido = partidoId -- Alias explícito para evitar ambigüedad
    RETURNING partido.idpartido AS idPartido, 
              partido.fechapartido AS fechaPartido, 
              partido.marcadorlocal AS marcadorLocal, 
              partido.marcadorvisitante AS marcadorVisitante, 
              partido.idequipolocal AS idEquipoLocal, 
              partido.idequipovisitante AS idEquipoVisitante;
END;
$$;


ALTER FUNCTION public.delete_partido(partidoid integer) OWNER TO postgres;

--
-- Name: delete_user(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.delete_user(userid integer) RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    DELETE FROM Usuarios
    WHERE Usuarios.idusuario = userId
    RETURNING Usuarios.idusuario, Usuarios.nombreusuario, Usuarios.apellidousuario;
END;
$$;


ALTER FUNCTION public.delete_user(userid integer) OWNER TO postgres;

--
-- Name: get_all_apuestas(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_all_apuestas() RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer, golequipolocal integer, golequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        apuestas.idapuestas,
        apuestas.idusuario,
        apuestas.cantidadapostada,
        apuestas.fechaapuesta,
        apuestas.idestadoapuesta,
        apuestas.idpartido,
        apuestas.golequipolocal,
        apuestas.golequipovisitante
    FROM public.apuestas;
END;
$$;


ALTER FUNCTION public.get_all_apuestas() OWNER TO postgres;

--
-- Name: get_all_equipos(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_all_equipos() RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        e.idequipo AS idEquipo,
        e.nombreequipo AS nombreEquipo,
        e.representanteequipo AS representanteEquipo,
        e.fechafundacion AS fechaFundacion
    FROM equipos e;
END;
$$;


ALTER FUNCTION public.get_all_equipos() OWNER TO postgres;

--
-- Name: get_all_equipos(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_all_equipos(user_id integer) RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
DECLARE
    user_role VARCHAR;
BEGIN
    -- Obtener el rol del usuario
    SELECT get_user_role(user_id) INTO user_role;

    -- Validar rol permitido
    IF user_role IN ('usuario', 'admin', 'superadmin') THEN
        RETURN QUERY SELECT * FROM equipos;
    ELSE
        RAISE EXCEPTION 'Permiso denegado';
    END IF;
END;
$$;


ALTER FUNCTION public.get_all_equipos(user_id integer) OWNER TO postgres;

--
-- Name: get_all_partidos(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_all_partidos() RETURNS TABLE(idpartido integer, fechapartido date, marcadorlocal integer, marcadorvisitante integer, equipolocal text, equipovisitante text)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        p.idpartido AS idPartido,
        p.fechapartido AS fechaPartido,
        p.marcadorlocal AS marcadorLocal,
        p.marcadorvisitante AS marcadorVisitante,
        el.nombreequipo::TEXT AS equipoLocal, -- Convertir a TEXT
        ev.nombreequipo::TEXT AS equipoVisitante -- Convertir a TEXT
    FROM partido p
    JOIN equipos el ON p.idequipolocal = el.idequipo
    JOIN equipos ev ON p.idequipovisitante = ev.idequipo;
END;
$$;


ALTER FUNCTION public.get_all_partidos() OWNER TO postgres;

--
-- Name: get_all_users(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_all_users() RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying, dui character varying, email character varying, username character varying, puntosuser integer, rol character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.idusuario,
        u.nombreusuario,
        u.apellidousuario,
        u.dui,
        u.email,
        u.username,
        u.puntosuser,
        r.tiporol
    FROM Usuarios u
    JOIN Roles r ON u.idrol = r.idrol;
END;
$$;


ALTER FUNCTION public.get_all_users() OWNER TO postgres;

--
-- Name: get_apuesta_by_id(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_apuesta_by_id(p_idapuestas integer) RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer, golequipolocal integer, golequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        apuestas.idapuestas,
        apuestas.idusuario,
        apuestas.cantidadapostada,
        apuestas.fechaapuesta,
        apuestas.idestadoapuesta,
        apuestas.idpartido,
        apuestas.golequipolocal,
        apuestas.golequipovisitante
    FROM public.apuestas
    WHERE apuestas.idapuestas = p_idapuestas;
END;
$$;


ALTER FUNCTION public.get_apuesta_by_id(p_idapuestas integer) OWNER TO postgres;

--
-- Name: get_apuestas_usuario(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_apuestas_usuario(user_id integer) RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer, golequipolocal integer, golequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
DECLARE
    user_role VARCHAR;
BEGIN
    -- Obtener el rol del usuario
    SELECT get_user_role(user_id) INTO user_role;

    -- Validar rol permitido
    IF user_role IN ('usuario', 'admin', 'superadmin') THEN
        RETURN QUERY 
        SELECT 
            apuestas.idapuestas,
            apuestas.idusuario,
            apuestas.cantidadapostada,
            apuestas.fechaapuesta,
            apuestas.idestadoapuesta,
            apuestas.idpartido,
            apuestas.golequipolocal,
            apuestas.golequipovisitante
        FROM public.apuestas
        WHERE apuestas.idusuario = user_id;
    ELSE
        RAISE EXCEPTION 'Permiso denegado';
    END IF;
END;
$$;


ALTER FUNCTION public.get_apuestas_usuario(user_id integer) OWNER TO postgres;

--
-- Name: get_equipo_by_id(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_equipo_by_id(equipoid integer) RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        e.idequipo AS idEquipo,
        e.nombreequipo AS nombreEquipo,
        e.representanteequipo AS representanteEquipo,
        e.fechafundacion AS fechaFundacion
    FROM equipos e
    WHERE e.idequipo = equipoId;
END;
$$;


ALTER FUNCTION public.get_equipo_by_id(equipoid integer) OWNER TO postgres;

--
-- Name: get_equipo_by_name(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_equipo_by_name(param_nombre character varying) RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT
        e.idequipo AS idEquipo,
        e.nombreequipo AS nombreEquipo,
        e.representanteequipo AS representanteEquipo,
        e.fechafundacion AS fechaFundacion
    FROM equipos e
    WHERE e.nombreequipo ILIKE '%' || param_nombre || '%'; -- Búsqueda parcial
END;
$$;


ALTER FUNCTION public.get_equipo_by_name(param_nombre character varying) OWNER TO postgres;

--
-- Name: get_partido_by_id(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_partido_by_id(partidoid integer) RETURNS TABLE(idpartido integer, fechapartido date, marcadorlocal integer, marcadorvisitante integer, equipolocal text, equipovisitante text)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        p.idpartido AS idPartido,
        p.fechapartido AS fechaPartido,
        p.marcadorlocal AS marcadorLocal,
        p.marcadorvisitante AS marcadorVisitante,
        el.nombreequipo::TEXT AS equipoLocal, -- Convertir a TEXT
        ev.nombreequipo::TEXT AS equipoVisitante -- Convertir a TEXT
    FROM partido p
    JOIN equipos el ON p.idequipolocal = el.idequipo
    JOIN equipos ev ON p.idequipovisitante = ev.idequipo
    WHERE p.idpartido = partidoId;
END;
$$;


ALTER FUNCTION public.get_partido_by_id(partidoid integer) OWNER TO postgres;

--
-- Name: get_user_by_email(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_user_by_email(param_email text) RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying, dui character varying, email character varying, username character varying, puntosuser integer, idrol integer, clave character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT
        u.idusuario AS idUsuario,
        u.nombreusuario AS nombreUsuario,
        u.apellidousuario AS apellidoUsuario,
        u.dui AS dui,
        u.email AS email,
        u.username AS userName,
        u.puntosuser AS puntosUser,
        u.idrol AS idRol,
        u.clave AS clave
    FROM usuarios u
    WHERE u.email = param_email;
END;
$$;


ALTER FUNCTION public.get_user_by_email(param_email text) OWNER TO postgres;

--
-- Name: get_user_by_id(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_user_by_id(userid integer) RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying, dui character varying, email character varying, username character varying, puntosuser integer, rol character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.idusuario,
        u.nombreusuario,
        u.apellidousuario,
        u.dui,
        u.email,
        u.username,
        u.puntosuser,
        r.tiporol
    FROM Usuarios u
    JOIN Roles r ON u.idrol = r.idrol
    WHERE u.idusuario = userId;
END;
$$;


ALTER FUNCTION public.get_user_by_id(userid integer) OWNER TO postgres;

--
-- Name: get_user_role(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.get_user_role(user_id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
DECLARE
    user_role VARCHAR;
BEGIN
    -- Obtener el tipo de rol del usuario
    SELECT r.tiporol INTO user_role
    FROM usuarios u
    JOIN roles r ON u.idrol = r.idrol
    WHERE u.idusuario = user_id;

    -- Devolver el tipo de rol
    RETURN user_role;
END;
$$;


ALTER FUNCTION public.get_user_role(user_id integer) OWNER TO postgres;

--
-- Name: llenar_puntos_user(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.llenar_puntos_user() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF NEW.puntosUser IS NULL THEN
        NEW.puntosUser := 100;
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.llenar_puntos_user() OWNER TO postgres;

--
-- Name: set_fecha_apuesta(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.set_fecha_apuesta() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF NEW.fechaApuesta IS NULL THEN
        NEW.fechaApuesta := CURRENT_DATE;
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.set_fecha_apuesta() OWNER TO postgres;

--
-- Name: set_fecha_fundacion_equipo(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.set_fecha_fundacion_equipo() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF NEW.fechaFundacion IS NULL THEN
        NEW.fechaFundacion := CURRENT_DATE;
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.set_fecha_fundacion_equipo() OWNER TO postgres;

--
-- Name: update_apuesta(integer, integer, numeric, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_apuesta(apuestaid integer, usuarioid integer, cantidad numeric, estadoapuestaid integer, partidoid integer) RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    UPDATE apuestas
    SET
        idusuario = COALESCE(usuarioId, apuestas.idusuario),
        cantidadapostada = COALESCE(cantidad, apuestas.cantidadapostada),
        idestadoapuesta = COALESCE(estadoApuestaId, apuestas.idestadoapuesta),
        idpartido = COALESCE(partidoId, apuestas.idpartido)
    WHERE apuestas.idapuestas = apuestaId
    RETURNING
        apuestas.idapuestas AS idApuestas,
        apuestas.idusuario AS idUsuario,
        apuestas.cantidadapostada AS cantidadApostada,
        apuestas.fechaapuesta AS fechaApuesta,
        apuestas.idestadoapuesta AS idEstadoApuesta,
        apuestas.idpartido AS idPartido;
END;
$$;


ALTER FUNCTION public.update_apuesta(apuestaid integer, usuarioid integer, cantidad numeric, estadoapuestaid integer, partidoid integer) OWNER TO postgres;

--
-- Name: update_apuesta(integer, integer, numeric, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_apuesta(p_idapuestas integer, p_idusuario integer, p_cantidadapostada numeric, p_idestadoapuesta integer, p_idpartido integer, p_golequipolocal integer, p_golequipovisitante integer) RETURNS TABLE(idapuestas integer, idusuario integer, cantidadapostada numeric, fechaapuesta date, idestadoapuesta integer, idpartido integer, golequipolocal integer, golequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    UPDATE public.apuestas
    SET
        idusuario = COALESCE(p_idUsuario, idusuario),
        cantidadapostada = COALESCE(p_cantidadApostada, cantidadapostada),
        idestadoapuesta = COALESCE(p_idEstadoApuesta, idestadoapuesta),
        idpartido = COALESCE(p_idPartido, idpartido),
        golequipolocal = COALESCE(p_golEquipoLocal, golequipolocal),
        golequipovisitante = COALESCE(p_golEquipoVisitante, golequipovisitante)
    WHERE idapuestas = p_idapuestas
    RETURNING *;
END;
$$;


ALTER FUNCTION public.update_apuesta(p_idapuestas integer, p_idusuario integer, p_cantidadapostada numeric, p_idestadoapuesta integer, p_idpartido integer, p_golequipolocal integer, p_golequipovisitante integer) OWNER TO postgres;

--
-- Name: update_equipo(integer, character varying, character varying, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_equipo(equipoid integer, nombre character varying, representante character varying, fecha date) RETURNS TABLE(idequipo integer, nombreequipo character varying, representanteequipo character varying, fechafundacion date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    UPDATE equipos e -- Usamos un alias explícito "e"
    SET
        nombreequipo = COALESCE(nombre, e.nombreequipo),
        representanteequipo = COALESCE(representante, e.representanteequipo),
        fechafundacion = COALESCE(fecha, e.fechafundacion)
    WHERE e.idequipo = equipoId -- Alias explícito aquí
    RETURNING
        e.idequipo AS idEquipo,
        e.nombreequipo AS nombreEquipo,
        e.representanteequipo AS representanteEquipo,
        e.fechafundacion AS fechaFundacion;
END;
$$;


ALTER FUNCTION public.update_equipo(equipoid integer, nombre character varying, representante character varying, fecha date) OWNER TO postgres;

--
-- Name: update_partido(integer, date, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_partido(partidoid integer, param_fecha date, param_marcadorlocal integer, param_marcadorvisitante integer, param_equipolocalid integer, param_equipovisitanteid integer) RETURNS TABLE(idpartido integer, fechapartido date, marcadorlocal integer, marcadorvisitante integer, idequipolocal integer, idequipovisitante integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    UPDATE partido
    SET 
        fechapartido = COALESCE(param_fecha, partido.fechapartido),
        marcadorlocal = COALESCE(param_marcadorLocal, partido.marcadorlocal),
        marcadorvisitante = COALESCE(param_marcadorVisitante, partido.marcadorvisitante),
        idequipolocal = COALESCE(param_equipoLocalId, partido.idequipolocal),
        idequipovisitante = COALESCE(param_equipoVisitanteId, partido.idequipovisitante)
    WHERE partido.idpartido = partidoId
    RETURNING partido.idpartido AS idPartido, 
              partido.fechapartido AS fechaPartido, 
              partido.marcadorlocal AS marcadorLocal, 
              partido.marcadorvisitante AS marcadorVisitante, 
              partido.idequipolocal AS idEquipoLocal, 
              partido.idequipovisitante AS idEquipoVisitante;
END;
$$;


ALTER FUNCTION public.update_partido(partidoid integer, param_fecha date, param_marcadorlocal integer, param_marcadorvisitante integer, param_equipolocalid integer, param_equipovisitanteid integer) OWNER TO postgres;

--
-- Name: update_user(integer, text, text, text, text, text, text, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_user(userid integer, nombre text, apellido text, param_dui text, correo text, usuario text, param_clave text, puntos integer, rol integer) RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying, email character varying, username character varying, puntosuser integer, idrol integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    UPDATE Usuarios
    SET 
        nombreusuario = COALESCE(nombre, Usuarios.nombreusuario),
        apellidousuario = COALESCE(apellido, Usuarios.apellidousuario),
        dui = COALESCE(param_dui, Usuarios.dui),
        email = COALESCE(correo, Usuarios.email),
        username = COALESCE(usuario, Usuarios.username),
        clave = COALESCE(param_clave, Usuarios.clave), -- Uso del nuevo nombre del parámetro
        puntosuser = COALESCE(puntos, Usuarios.puntosuser),
        idrol = COALESCE(rol, Usuarios.idrol)
    WHERE Usuarios.idusuario = userId
    RETURNING Usuarios.idusuario AS idUsuario, 
              Usuarios.nombreusuario AS nombreUsuario, 
              Usuarios.apellidousuario AS apellidoUsuario, 
              Usuarios.email AS email, 
              Usuarios.username AS userName, 
              Usuarios.puntosuser AS puntosUser, 
              Usuarios.idrol AS idRol;
END;
$$;


ALTER FUNCTION public.update_user(userid integer, nombre text, apellido text, param_dui text, correo text, usuario text, param_clave text, puntos integer, rol integer) OWNER TO postgres;

--
-- Name: update_user(integer, character varying, character varying, character varying, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_user(userid integer, nombre character varying, apellido character varying, dui character varying, correo character varying, usuario character varying, clave character varying, puntos integer, rol integer) RETURNS TABLE(idusuario integer, nombreusuario character varying, apellidousuario character varying, email character varying, username character varying, puntosuser integer, idrol integer)
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE Usuarios
    SET 
        nombreusuario = COALESCE(nombre, nombreusuario),
        apellidousuario = COALESCE(apellido, apellidousuario),
        dui = COALESCE(dui, dui),
        email = COALESCE(correo, email),
        username = COALESCE(usuario, username),
        clave = COALESCE(clave, clave),
        puntosuser = COALESCE(puntos, puntosuser),
        idrol = COALESCE(rol, idrol)
    WHERE idusuario = userId
    RETURNING idusuario, nombreusuario, apellidousuario, email, username, puntosuser, idrol;
END;
$$;


ALTER FUNCTION public.update_user(userid integer, nombre character varying, apellido character varying, dui character varying, correo character varying, usuario character varying, clave character varying, puntos integer, rol integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: apuestas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.apuestas (
    idapuestas integer NOT NULL,
    idusuario integer NOT NULL,
    cantidadapostada numeric(10,3) NOT NULL,
    fechaapuesta date DEFAULT CURRENT_DATE,
    idestadoapuesta integer NOT NULL,
    idpartido integer NOT NULL,
    golequipolocal integer DEFAULT 0 NOT NULL,
    golequipovisitante integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.apuestas OWNER TO postgres;

--
-- Name: apuestas_idapuestas_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.apuestas_idapuestas_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.apuestas_idapuestas_seq OWNER TO postgres;

--
-- Name: apuestas_idapuestas_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.apuestas_idapuestas_seq OWNED BY public.apuestas.idapuestas;


--
-- Name: equipos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.equipos (
    idequipo integer NOT NULL,
    nombreequipo character varying(50) NOT NULL,
    representanteequipo character varying(120) NOT NULL,
    fechafundacion date
);


ALTER TABLE public.equipos OWNER TO postgres;

--
-- Name: equipos_idequipo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.equipos_idequipo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.equipos_idequipo_seq OWNER TO postgres;

--
-- Name: equipos_idequipo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.equipos_idequipo_seq OWNED BY public.equipos.idequipo;


--
-- Name: estadoapuesta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estadoapuesta (
    idestadoapuesta integer NOT NULL,
    estadodeapuesta character varying(50) NOT NULL,
    CONSTRAINT estado_check CHECK (((estadodeapuesta)::text = ANY ((ARRAY['pendiente'::character varying, 'ganada'::character varying, 'perdida'::character varying, 'empate'::character varying])::text[])))
);


ALTER TABLE public.estadoapuesta OWNER TO postgres;

--
-- Name: estadoapuesta_idestadoapuesta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estadoapuesta_idestadoapuesta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estadoapuesta_idestadoapuesta_seq OWNER TO postgres;

--
-- Name: estadoapuesta_idestadoapuesta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estadoapuesta_idestadoapuesta_seq OWNED BY public.estadoapuesta.idestadoapuesta;


--
-- Name: partido; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.partido (
    idpartido integer NOT NULL,
    fechapartido date NOT NULL,
    marcadorlocal integer,
    marcadorvisitante integer,
    idequipolocal integer NOT NULL,
    idequipovisitante integer NOT NULL
);


ALTER TABLE public.partido OWNER TO postgres;

--
-- Name: partido_idpartido_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.partido_idpartido_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.partido_idpartido_seq OWNER TO postgres;

--
-- Name: partido_idpartido_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.partido_idpartido_seq OWNED BY public.partido.idpartido;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    idrol integer NOT NULL,
    tiporol character varying(70) NOT NULL
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_idrol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_idrol_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_idrol_seq OWNER TO postgres;

--
-- Name: roles_idrol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_idrol_seq OWNED BY public.roles.idrol;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    idusuario integer NOT NULL,
    nombreusuario character varying(70) NOT NULL,
    apellidousuario character varying(70) NOT NULL,
    dui character varying(10),
    email character varying(200) NOT NULL,
    username character varying(50) NOT NULL,
    clave character varying(128) NOT NULL,
    puntosuser integer DEFAULT 0,
    idrol integer NOT NULL
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- Name: usuarios_idusuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_idusuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_idusuario_seq OWNER TO postgres;

--
-- Name: usuarios_idusuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_idusuario_seq OWNED BY public.usuarios.idusuario;


--
-- Name: apuestas idapuestas; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.apuestas ALTER COLUMN idapuestas SET DEFAULT nextval('public.apuestas_idapuestas_seq'::regclass);


--
-- Name: equipos idequipo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipos ALTER COLUMN idequipo SET DEFAULT nextval('public.equipos_idequipo_seq'::regclass);


--
-- Name: estadoapuesta idestadoapuesta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estadoapuesta ALTER COLUMN idestadoapuesta SET DEFAULT nextval('public.estadoapuesta_idestadoapuesta_seq'::regclass);


--
-- Name: partido idpartido; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.partido ALTER COLUMN idpartido SET DEFAULT nextval('public.partido_idpartido_seq'::regclass);


--
-- Name: roles idrol; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN idrol SET DEFAULT nextval('public.roles_idrol_seq'::regclass);


--
-- Name: usuarios idusuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN idusuario SET DEFAULT nextval('public.usuarios_idusuario_seq'::regclass);


--
-- Name: apuestas apuestas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.apuestas
    ADD CONSTRAINT apuestas_pkey PRIMARY KEY (idapuestas);


--
-- Name: equipos equipos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (idequipo);


--
-- Name: estadoapuesta estadoapuesta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estadoapuesta
    ADD CONSTRAINT estadoapuesta_pkey PRIMARY KEY (idestadoapuesta);


--
-- Name: partido partido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.partido
    ADD CONSTRAINT partido_pkey PRIMARY KEY (idpartido);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (idrol);


--
-- Name: apuestas unique_apuesta_usuario_partido_cantidad; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.apuestas
    ADD CONSTRAINT unique_apuesta_usuario_partido_cantidad UNIQUE (idusuario, idpartido, cantidadapostada);


--
-- Name: equipos unique_nombreequipo; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipos
    ADD CONSTRAINT unique_nombreequipo UNIQUE (nombreequipo);


--
-- Name: partido unique_partido_fecha_equipos; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.partido
    ADD CONSTRAINT unique_partido_fecha_equipos UNIQUE (fechapartido, idequipolocal, idequipovisitante);


--
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (idusuario);


--
-- Name: usuarios usuarios_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_username_key UNIQUE (username);


--
-- Name: usuarios llenarpuntosuser; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER llenarpuntosuser BEFORE INSERT ON public.usuarios FOR EACH ROW EXECUTE FUNCTION public.llenar_puntos_user();


--
-- Name: apuestas tr_set_fecha_apuesta; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER tr_set_fecha_apuesta BEFORE INSERT ON public.apuestas FOR EACH ROW EXECUTE FUNCTION public.set_fecha_apuesta();


--
-- Name: equipos tr_set_fecha_fundacion_equipo; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER tr_set_fecha_fundacion_equipo BEFORE INSERT ON public.equipos FOR EACH ROW EXECUTE FUNCTION public.set_fecha_fundacion_equipo();


--
-- Name: apuestas apuestas_idestadoapuesta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.apuestas
    ADD CONSTRAINT apuestas_idestadoapuesta_fkey FOREIGN KEY (idestadoapuesta) REFERENCES public.estadoapuesta(idestadoapuesta) ON DELETE SET NULL;


--
-- Name: apuestas apuestas_idpartido_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.apuestas
    ADD CONSTRAINT apuestas_idpartido_fkey FOREIGN KEY (idpartido) REFERENCES public.partido(idpartido) ON DELETE CASCADE;


--
-- Name: apuestas apuestas_idusuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.apuestas
    ADD CONSTRAINT apuestas_idusuario_fkey FOREIGN KEY (idusuario) REFERENCES public.usuarios(idusuario) ON DELETE CASCADE;


--
-- Name: partido partido_idequipolocal_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.partido
    ADD CONSTRAINT partido_idequipolocal_fkey FOREIGN KEY (idequipolocal) REFERENCES public.equipos(idequipo) ON DELETE CASCADE;


--
-- Name: partido partido_idequipovisitante_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.partido
    ADD CONSTRAINT partido_idequipovisitante_fkey FOREIGN KEY (idequipovisitante) REFERENCES public.equipos(idequipo) ON DELETE CASCADE;


--
-- Name: usuarios usuarios_idrol_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_idrol_fkey FOREIGN KEY (idrol) REFERENCES public.roles(idrol) ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

GRANT USAGE ON SCHEMA public TO maria;


--
-- Name: TABLE apuestas; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.apuestas TO maria;


--
-- Name: SEQUENCE apuestas_idapuestas_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.apuestas_idapuestas_seq TO maria;


--
-- Name: TABLE equipos; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.equipos TO maria;


--
-- Name: SEQUENCE equipos_idequipo_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.equipos_idequipo_seq TO maria;


--
-- Name: TABLE estadoapuesta; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.estadoapuesta TO maria;


--
-- Name: SEQUENCE estadoapuesta_idestadoapuesta_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.estadoapuesta_idestadoapuesta_seq TO maria;


--
-- Name: TABLE partido; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.partido TO maria;


--
-- Name: SEQUENCE partido_idpartido_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.partido_idpartido_seq TO maria;


--
-- Name: TABLE roles; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.roles TO maria;


--
-- Name: SEQUENCE roles_idrol_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.roles_idrol_seq TO maria;


--
-- Name: TABLE usuarios; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.usuarios TO maria;


--
-- Name: SEQUENCE usuarios_idusuario_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.usuarios_idusuario_seq TO maria;


--
-- Name: DEFAULT PRIVILEGES FOR TABLES; Type: DEFAULT ACL; Schema: public; Owner: postgres
--

ALTER DEFAULT PRIVILEGES FOR ROLE postgres IN SCHEMA public GRANT SELECT,INSERT,DELETE,UPDATE ON TABLES  TO maria;


--
-- PostgreSQL database dump complete
--

