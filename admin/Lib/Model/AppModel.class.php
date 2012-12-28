<?php
class AppModel extends Model {
    protected $_auto = array(
        array('created', 'time', Model::MODEL_INSERT, 'function'),
        array('modified', 'time', Model::MODEL_BOTH, 'function'),
    );
}
