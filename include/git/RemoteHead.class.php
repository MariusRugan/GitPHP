<?php
/**
 * GitPHP RemoteHead
 *
 * Represents a single remote head
 *
 * @author Tanguy Pruvot <tanguy.pruvot@gmail.com>
 * @author Christopher Han <xiphux@gmail.com>
 * @copyright Copyright (c) 2010 Christopher Han
 * @package GitPHP
 * @subpackage Git
 */

require_once(GITPHP_GITOBJECTDIR . 'Ref.class.php');

/**
 * RemoteHead class
 *
 * @package GitPHP
 * @subpackage Git
 */
class GitPHP_RemoteHead extends GitPHP_Ref
{

	/**
	 * commit
	 *
	 * Stores the commit internally
	 *
	 * @access protected
	 */
	protected $commit;

	/**
	 * __construct
	 *
	 * Instantiates head
	 *
	 * @access public
	 * @param mixed $project the project
	 * @param string $head head name
	 * @param string $headHash head hash
	 * @return mixed head object
	 * @throws Exception exception on invalid head or hash
	 */
	public function __construct($project, $head, $headHash = '', $refDir='remotes')
	{
		parent::__construct($project, $refDir, $head, $headHash);
	}

	/*
	 * GetRemoteName
	 * 
	 * @access public
	 * @return string
	 */
	public function GetRemoteName() {
		$ref = $this->GetName();

		// exclude branch name
		$ar = explode('/',$ref);
		array_pop($ar);
		$remote = implode('/',$ar);

		return $remote;
	}

	/**
	 * GetCommit
	 *
	 * Gets the commit for this head
	 *
	 * @access public
	 * @return mixed commit object for this tag
	 */
	public function GetCommit()
	{
		if (!$this->commit) {
			$this->commit = $this->project->GetCommit($this->GetHash());
		}

		return $this->commit;
	}
	
	/**
	 * CompareAge
	 *
	 * Compares two heads by age
	 *
	 * @access public
	 * @static
	 * @param mixed $a first head
	 * @param mixed $b second head
	 * @return integer comparison result
	 */
	public static function CompareAge($a, $b)
	{
		$aObj = $a->GetCommit();
		$bObj = $b->GetCommit();
		return GitPHP_Commit::CompareAge($aObj, $bObj);
	}

}
