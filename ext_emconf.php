<?php

/***************************************************************
 *  Copyright notice
 *
 *  Update of "kb_tv_cont_slide" to work with templavoilaplus
 *  Original author:
 *  (c) 2004-2014 Bernhard Kraft (kraftb@think-open.at)
 *
 *  Current maintainer:
 *  (c) 2016-2022 J. Peter M. Schuler (j.peter.m.schuler@uni-due.de)
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

$EM_CONF['powermail_limits'] = [
    'title' => 'powermail_limits',
    'description' => 'Addition to EXT:powermail which allows limits for form submissions',
    'category' => 'plugin',
    'version' => '0.2.4',
    'state' => 'stable',
    'author' => 'Schuler, J. Peter M.',
    'author_email' => 'j.peter.m.schuler@uni-due.de',
    'author_company' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99'
        ]
    ]
];
