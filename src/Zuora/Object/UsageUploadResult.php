<?php

namespace Zuora\Object;

class UsageUploadResult extends ZuoraObject
{
    /**
     * Retrieve uploaded file size
     *
     * @return int
     */
    public function getFileSize()
    {
        return $this->size;
    }

    /**
     * Retrieve status URL.
     *
     * @return string
     *  URL
     */
    public function getImportStatusUrl()
    {
        return $this->checkImportStatus;
    }

    /**
     * Return import status id.
     *
     * @return string
     */
    public function getImportStatusId()
    {
        preg_match('~usage/(?<id>[^/]+)/status~i', $this->getImportStatusUrl(), $match);
        return isset($match['id']) ? $match['id'] : null;
    }
}
