<?php defined('ABS_PATH') or die('Access denied');

class USLModel extends DAO {
    
    private static $instance;

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    function __construct() {
        parent::__construct();
        
        $this->setTableName('t_usl_soc_networks');
        $this->setPrimaryKey('usl_id');
        
        $arr_fields = array(
                        'usl_id', 
                        'usl_name', 
                        'usl_code', 
                        'usl_ph_id',
                        'usl_ph_secret',
                        'usl_position'     
                    );
        $this->setFields($arr_fields);
    }
    
    public function import($file) {
        $sql = file_get_contents($file);

        if(!$this->dao->importSQL($sql) ) {
            throw new Exception($this->dao->getErrorLevel() . ' - ' . $this->dao->getErrorDesc()) ;
        }
    }
    
    public function install() {
        $this->import(USL_PATH . 'struct.sql');
		osc_set_preference('version', '110', 'usl_settings', 'INTEGER');
    }
    
    public function uninstall() {
        $this->dao->query(sprintf('DROP TABLE %s', $this->getTableName()));
        Preference::newInstance()->delete(array('s_section' => 'usl_settings'));
    }
    
    public function getSocNetworks() {
        $this->dao->select();
        $this->dao->from($this->getTableName());
        $this->dao->orderBy('usl_position');
        
        $result = $this->dao->get();
        
        if($result) return $result->result();
        
        return array();
    }
    
    public function updateSocNetworkPositions($id, $position) {
        $result = $this->dao->update(
                        $this->getTableName(),
                        array('usl_position' => $position),
                        array('usl_id' => $id) 
                    );
                    
        return $result;
    }
}