<?php

require_once ZEND_PATH . 'Acl.php';
/**
 * @see Zend_Acl_Resource_Interface
 */
require_once ZEND_PATH . 'Acl/Resource/Interface.php';
/**
 * @see Zend_Acl_Role_Registry
 */
require_once ZEND_PATH . 'Acl/Role/Registry.php';
/**
 * @see Zend_Acl_Assert_Interface
 */
require_once ZEND_PATH . 'Acl/Assert/Interface.php';
/**
 * @see Zend_Acl_Role
 */
require_once ZEND_PATH . 'Acl/Role.php';
/**
 * @see Zend_Acl_Resource
 */
require_once ZEND_PATH . 'Acl/Resource.php';
/**
 * @see Zend_Exception
 */
require_once ZEND_PATH . 'Exception.php';
/**
 * @see Zend_Acl_Exception
 */
require_once ZEND_PATH . 'Acl/Exception.php';

class Acl_Config extends Zend_Acl 
{
	
	protected $page;

	public function __construct() 
	{
		$this->page = "../access_denied.html";
		
		$this->addRole(new Zend_Acl_Role('general')); 
		$this->addRole(new Zend_Acl_Role('administrador'), 'general');
		
		//Agregar recursos  


		$this->add(new Zend_Acl_Resource('foros'))
			 ->add(new Zend_Acl_Resource('usuarios'))
			 ->add(new Zend_Acl_Resource('grupos'))
			 ->add(new Zend_Acl_Resource('objetos'))
			 ->add(new Zend_Acl_Resource('mensajes'))
			 ->add(new Zend_Acl_Resource('index'))
			 ->add(new Zend_Acl_Resource('inicio'))
			 ->add(new Zend_Acl_Resource('foros_control'))
			 ->add(new Zend_Acl_Resource('foros_control-nuevo'))
			 ->add(new Zend_Acl_Resource('foros_control-modificar'))
			 ->add(new Zend_Acl_Resource('foros_control-eliminar'))
			 ->add(new Zend_Acl_Resource('foros_tipo'))
			 ->add(new Zend_Acl_Resource('foros_tipo-nuevo'))
			 ->add(new Zend_Acl_Resource('foros_tipo-modificar'))
			 ->add(new Zend_Acl_Resource('foros_tipo-eliminar'))
			 ->add(new Zend_Acl_Resource('foros_comentarios'))
			 ->add(new Zend_Acl_Resource('foros_comentarios-nuevo'))
			 ->add(new Zend_Acl_Resource('foros_comentarios-eliminar'))
			 ->add(new Zend_Acl_Resource('usuarios_control'))
			 ->add(new Zend_Acl_Resource('usuarios_control-nuevo'))
			 ->add(new Zend_Acl_Resource('usuarios_control-modificar'))
			 ->add(new Zend_Acl_Resource('usuarios_control-eliminar'))
			 ->add(new Zend_Acl_Resource('grupos_control'))
			 ->add(new Zend_Acl_Resource('grupos_control-nuevo'))
			 ->add(new Zend_Acl_Resource('grupos_control-modificar'))
			 ->add(new Zend_Acl_Resource('grupos_control-eliminar'))
			 ->add(new Zend_Acl_Resource('grupos_agregarusuarios'))
			 ->add(new Zend_Acl_Resource('grupos_agregarusuarios-nuevo'))
			 ->add(new Zend_Acl_Resource('grupos_agregarusuarios-eliminar'))
			 ->add(new Zend_Acl_Resource('grupos_agregartemas'))
			 ->add(new Zend_Acl_Resource('grupos_agregartemas-nuevo'))
			 ->add(new Zend_Acl_Resource('grupos_agregartemas-eliminar'))
			 ->add(new Zend_Acl_Resource('objetos_subir'))
			 ->add(new Zend_Acl_Resource('objetos_subir-nuevo'))
			 ->add(new Zend_Acl_Resource('objetos_subir-eliminar'))
			 ->add(new Zend_Acl_Resource('objetos_subir-modificar'))
			 ->add(new Zend_Acl_Resource('objetos_consulta'))
			 ->add(new Zend_Acl_Resource('objetos_tema'))
			 ->add(new Zend_Acl_Resource('objetos_tema-nuevo'))
			 ->add(new Zend_Acl_Resource('objetos_tema-modificar'))
			 ->add(new Zend_Acl_Resource('objetos_tema-eliminar'))
			 ->add(new Zend_Acl_Resource('objetos_subtema'))
			 ->add(new Zend_Acl_Resource('objetos_subtema-nuevo'))
			 ->add(new Zend_Acl_Resource('objetos_subtema-modificar'))
			 ->add(new Zend_Acl_Resource('objetos_subtema-eliminar'))
			 ->add(new Zend_Acl_Resource('objetos_ver'))
			 ->add(new Zend_Acl_Resource('mensajes_bandeja'))
			 ->add(new Zend_Acl_Resource('mensajes_bandeja-ver'))
			 ->add(new Zend_Acl_Resource('mensajes_bandeja-eliminar'))
			 ->add(new Zend_Acl_Resource('mensajes_salida'))
			 ->add(new Zend_Acl_Resource('mensajes_salida-nuevo'))
			 ->add(new Zend_Acl_Resource('mensajes_salida-ver'))
			 ->add(new Zend_Acl_Resource('mensajes_salida-eliminar'))
			 ->add(new Zend_Acl_Resource('cambiarpass'))
			 ;

		//Finalmente agregamos los permisos a los roles que queremos permitirle el acceso

		$this->allow('general', 'foros');
		$this->allow('administrador', 'usuarios');
		$this->allow('general', 'grupos');
		$this->allow('general', 'objetos');
		$this->allow('general', 'index');
		$this->allow('general', 'inicio');
		$this->allow('general', 'mensajes');
		$this->allow('administrador', 'foros_control');
		$this->allow('administrador', 'foros_control-nuevo');
		$this->allow('administrador', 'foros_control-modificar');
		$this->allow('administrador', 'foros_control-eliminar');
		$this->allow('administrador', 'foros_tipo');
		$this->allow('administrador', 'foros_tipo-nuevo');
		$this->allow('administrador', 'foros_tipo-modificar');
		$this->allow('administrador', 'foros_tipo-eliminar');
		$this->allow('general', 'foros_comentarios');
		$this->allow('general', 'foros_comentarios-nuevo');
		$this->allow('administrador', 'foros_comentarios-eliminar');
		$this->allow('administrador', 'usuarios_control');
		$this->allow('administrador', 'usuarios_control-nuevo');
		$this->allow('administrador', 'usuarios_control-modificar');
		$this->allow('administrador', 'usuarios_control-eliminar');
		$this->allow('administrador', 'grupos_control');
		$this->allow('administrador', 'grupos_control-nuevo');
		$this->allow('administrador', 'grupos_control-modificar');
		$this->allow('administrador', 'grupos_control-eliminar');
		$this->allow('administrador', 'grupos_agregarusuarios');
		$this->allow('administrador', 'grupos_agregarusuarios-nuevo');
		$this->allow('administrador', 'grupos_agregarusuarios-eliminar');
		$this->allow('administrador', 'grupos_agregartemas');
		$this->allow('administrador', 'grupos_agregartemas-nuevo');
		$this->allow('administrador', 'grupos_agregartemas-eliminar');
		$this->allow('administrador', 'objetos_subir');
		$this->allow('administrador', 'objetos_subir-nuevo');
		$this->allow('administrador', 'objetos_subir-modificar');
		$this->allow('administrador', 'objetos_subir-eliminar');
		$this->allow('general', 'objetos_consulta');
		$this->allow('general', 'objetos_tema');
		$this->allow('administrador', 'objetos_tema-nuevo');
		$this->allow('administrador', 'objetos_tema-modificar');
		$this->allow('administrador', 'objetos_tema-eliminar');
		$this->allow('general', 'objetos_subtema');
		$this->allow('administrador', 'objetos_subtema-nuevo');
		$this->allow('administrador', 'objetos_subtema-modificar');
		$this->allow('administrador', 'objetos_subtema-eliminar');
		$this->allow('general', 'objetos_ver');
		$this->allow('general', 'mensajes_bandeja');
		$this->allow('general', 'mensajes_bandeja-ver');
		$this->allow('general', 'mensajes_bandeja-eliminar');
		$this->allow('general', 'mensajes_salida');
		$this->allow('general', 'mensajes_salida-nuevo');
		$this->allow('general', 'mensajes_salida-ver');
		$this->allow('general', 'mensajes_salida-eliminar');
		$this->allow('general', 'cambiarpass');
	}
	
	public function controlAcceso($roleName, $resourceName, $redirect_restric = true, $ActionName = ""){
		//var_dump($_SERVER);
		 if ($this->isAllowed($roleName, $resourceName, $ActionName)) {
            
			return true;
        } else {
			/** Redirect to access denied page */
			if($redirect_restric)
				$this->denegarAcceso();
			return false;
		}	
	}
	
	public function denegarAcceso(){
		header ("Location: " . $this->page);
	}
}