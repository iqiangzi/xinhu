<?php
class sysClassAction extends runtAction
{
	//数据备份
	public function beifenAction()
	{
		m('beifen')->start();
		$this->todoarr	= array(
			'title' 	=> '数据库备份',
			'cont' 		=> '数据库在['.$this->now.']备份了。',
		);
		echo 'success';
	}
	public function upgtxAction()
	{
		$xinhu	= c('xinhu');
		$db 	= m('chargems');
		$lastdt	= strtotime($this->runrs['lastdt']);
		$barr	= $xinhu->getdata('modeupg', array('lastdt'=>$lastdt));
		if($barr['code']!=200)exit($barr['msg']);
		$str 	= '';
		foreach($barr['data'] as $k=>$rs){
			$id = $rs['id'];
			$na = $rs['name'];
			$state  = 0;
			$ors 	= $db->getone("`type`=0 and `mid`='$id'");
			if($ors){
				$state = 1;
				if($rs['updatedt']>$ors['updatedt'])$state=2;
			}
			if($state==0)$str.='模块['.$na.']可安装;';
			if($state==2)$str.='模块['.$na.']可<font color=red>升级</font>;';
		}
		if($str!=''){
			$this->todoarr	= array(
				'title' 	=> '安装升级',
				'cont' 		=> $str.'请到[系统→系统工具→系统升级]下处理',
			);
		}
		echo 'success';
	}
	
	
	//数据更新,更新用户的
	public function dataupAction()
	{
		m('admin')->updateinfo();
		$reim 	= m('reim');
		if($reim->installwx(0))m('weixin:user')->getuserlist();
		if($reim->installwx(1))m('weixinqy:user')->getuserlist();
		echo 'success';
	}
}