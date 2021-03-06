<?php
/**
 * Module for Magento 2 by Moloni
 * Copyright (C) 2017  Moloni, lda.
 *
 * This file is part of Invoicing/Moloni.
 *
 * Invoicing/Moloni is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Invoicing\Moloni\Controller\Adminhtml\Documents;

use Invoicing\Moloni\Controller\Adminhtml\Documents;
use JsonException;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Create extends Documents
{

    /**
     * @return bool|ResponseInterface|ResultInterface
     * @throws JsonException
     */
    public function execute()
    {
        if (!$this->moloni->checkActiveSession()) {
            $this->redirect->redirect($this->context->getResponse(), $this->moloni->redirectTo);
            return false;
        }

        $orderId = $this->request->getParam('order_id');

        if (!$orderId) {
            $this->messageManager->addErrorMessage(__("Encomenda não encontrada."));
            $this->redirect->redirect($this->context->getResponse(), 'moloni/home/index');
            return false;
        }

        if ($this->documentExists($orderId)) {
            $this->redirect->redirect($this->context->getResponse(), 'moloni/home/index');
            return false;
        }

        $newDocument = $this->moloniDocumentsFactory->create();
        $newDocument->createDocumentFromOrderId($orderId);
        $newDocument->throwMessages();

        $this->redirect->redirect($this->context->getResponse(), '*/home/index');
        return true;
    }
}
