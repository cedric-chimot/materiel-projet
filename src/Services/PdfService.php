<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    /**
     * @var Dompdf $domPDF
     * Instance de Dompdf
     */
    private $domPDF;

    /**
     * Constructeur initialisant les options Dompdf
     */
    public function __construct()
    {
        // Options Dompdf
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $this->domPDF = new Dompdf($options);
    }

    /**
     * @param string $htmlContent
     * Créer un PDF à partir d'un contenu HTML
    */
    public function showPdfFile($htmlContent)
    {    
        // Charger le contenu HTML
        $this->domPDF->loadHtml($htmlContent);
        
        // Rendre le PDF
        $this->domPDF->render();
    
        // Envoyer le PDF au navigateur
        $this->domPDF->stream("details.pdf", ["Attachment" => false]);
    }
    
    /**
     * Générer un PDF à partir d'un contenu HTML en format binaire
     *
     * @param [String] $html
     * @return void
     */
    public function generateBinaryPdf($html)
    {
        $this->domPDF->loadHtml($html);
        $this->domPDF->render();
        $this->domPDF->output();
    }

}
