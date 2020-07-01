<?php

/*
@version   v5.20.0  28-Nov-2015
@copyright (c) 2000-2013 John Lim (jlim#natsoft.com). All rights reserved.
@copyright (c) 2014      Damien Regad, Mark Newnham and the ADOdb community
         Contributed by Ross Smith (adodb@netebb.com).
  Released under both BSD license and Lesser GPL library license.
  Whenever there is any discrepancy between the two licenses,
  the BSD license will take precedence.
      Set tabs to 4 for best viewing.

*/

if (!function_exists('bzcompress')) {
    trigger_error('bzip2 functions are not available', E_USER_ERROR);
    return 0;
}

/*
*/

class ADODB_Compress_Bzip2
{
    /**
     */
    public $_block_size = null;

    /**
     */
    public $_work_level = null;

    /**
     */
    public $_min_length = 1;

    /**
     */
    public function getBlockSize()
    {
        return $this->_block_size;
    }

    /**
     */
    public function setBlockSize($block_size)
    {
        assert('$block_size >= 1');
        assert('$block_size <= 9');
        $this->_block_size = (int)$block_size;
    }

    /**
     */
    public function getWorkLevel()
    {
        return $this->_work_level;
    }

    /**
     */
    public function setWorkLevel($work_level)
    {
        assert('$work_level >= 0');
        assert('$work_level <= 250');
        $this->_work_level = (int)$work_level;
    }

    /**
     */
    public function getMinLength()
    {
        return $this->_min_length;
    }

    /**
     */
    public function setMinLength($min_length)
    {
        assert('$min_length >= 0');
        $this->_min_length = (int)$min_length;
    }

    /**
     */
    public function __construct($block_size = null, $work_level = null, $min_length = null)
    {
        if (!is_null($block_size)) {
            $this->setBlockSize($block_size);
        }

        if (!is_null($work_level)) {
            $this->setWorkLevel($work_level);
        }

        if (!is_null($min_length)) {
            $this->setMinLength($min_length);
        }
    }

    /**
     */
    public function write($data, $key)
    {
        if (strlen($data) < $this->_min_length) {
            return $data;
        }

        if (!is_null($this->_block_size)) {
            if (!is_null($this->_work_level)) {
                return bzcompress($data, $this->_block_size, $this->_work_level);
            } else {
                return bzcompress($data, $this->_block_size);
            }
        }

        return bzcompress($data);
    }

    /**
     */
    public function read($data, $key)
    {
        return $data ? bzdecompress($data) : $data;
    }
}

return 1;
