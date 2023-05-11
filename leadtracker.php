<?php
/*
Plugin Name: Lead Tracker
Plugin URI: https://leadtracker.com.br/
Description: Mensure, analise e acompanhe seus lançamentos.
Version: 1.0.1
Author: Leadtracker 
Author URI: https://leadtracker.com.br
License: GPLv2
*/

/*
 *      Copyright 2020 Leadtracker <contato@leadtracker.com.br>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
  
  /**
   * Inclui a classe LtkWp;
   */
  require_once(dirname(__FILE__).'/ltk-config.php');
 
  /** 
    * Chama a função na hora de ativar o plugin
    */
  register_activation_hook(__FILE__,array('LtkWp','instalar'));

  /** 
    * Chama a função na hora de desativar o plugin
    */
  register_deactivation_hook(__FILE__, array('LtkWp','desinstalar'));

  /**
    * Chama a função inicializar na hora de iniciar o Wp
    */
   add_filter('init', array('LtkWp','inicializar'));

?>