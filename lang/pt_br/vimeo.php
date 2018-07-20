<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package mod_vimeo
 * @author Bruno Magalhães <brunomagalhaes@blackbean.com.br>
 * @copyright BlackBean Technologies Ltda <https://www.blackbean.com.br>
 * @license http://www.gnu.org/copyleft/gpl.html
 */
defined('MOODLE_INTERNAL') || exit(0);

// Defining and registering this
// plug-in translation strings.
$string['pluginname'] = 'Vimeo';
$string['pluginnameplural'] = 'Vimeo';
$string['pluginadministration'] = 'Vimeo - Administração';
$string['modulename'] = 'Vimeo';
$string['modulename_help'] = 'Permite a utilização de videos do Vimeo junto à pataforma como uma ferramenta de ensino.';
$string['modulenameplural'] = 'Vimeo';
$string['moduleadministration'] = 'Vimeo - Administração';
$string['vimeo:addinstance'] = 'Incluir instância';
$string['vimeo'] = 'Vimeo';
$string['mod/vimeo'] = 'Vimeo';
$string['mod_vimeo'] = 'Vimeo';
$string['label_name'] = 'Nome';
$string['label_name_help'] = 'Este é o nome do video que aparecerá na lista de atividades do curso.';
$string['label_video'] = 'Vídeo';
$string['label_video_help'] = 'Este é a URL ou o ID do video que será usado como atividade do curso.';
$string['label_color'] = 'Cor';
$string['label_color_help'] = 'Esta é a cor (em hexadecimal) que será usada nos controles deste vídeo.';
$string['label_autoplay'] = 'Autoplay';
$string['label_autoplay_help'] = 'Se este vídeo será reproduzido automaticamente ou não.';
$string['label_autoloop'] = 'Autoloop';
$string['label_autoloop_help'] = 'Se este vídeo será repetido automaticamente ou não.';
$string['label_popupopen'] = 'Pop-up';
$string['label_popupopen_help'] = 'Se este vídeo será reproduzido em uma nova janela pop-up ou não.';
$string['label_popupwidth'] = 'Largura';
$string['label_popupwidth_help'] = 'Esta é a largura (em pixels) que será usada na nova janela pop-up deste vídeo.';
$string['label_popupheight'] = 'Altura';
$string['label_popupheight_help'] = 'Esta é a altura (em pixels) que será usada na nova janela pop-up deste vídeo.';
$string['label_completion'] = 'Completude';
$string['label_completion_help'] = 'Este é o percentual no este vídeo será automaticamente marcado como completado/assistido.';
$string['label_no'] = 'Não';
$string['label_yes'] = 'Sim';
$string['label_enable'] = 'Habilitar';
$string['label_disable'] = 'Desabilitar';
$string['label_enabled'] = 'Habilitado';
$string['label_disabled'] = 'Desabilitado';
$string['message_invalid_course'] = 'O curso fornecido é inválido.';
$string['message_invalid_name'] = 'O nome fornecido é inválido.';
$string['message_invalid_video'] = 'O video fornecido é inválido.';