<?php

namespace Zuora\Object;


class ImportStatus extends ZuoraObject {

    /**
     * @return mixed
     */
    public function getImportStatus()
    {
        return $this->importStatus;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

} 