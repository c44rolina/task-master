<?php
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase {
    public function testApiRetornaListaEmJson() {
        // Ajuste: usamos o servidor embutido do PHP na porta 8000
        $url = "http://127.0.0.1:8000/api.php?action=list";
        $content = @file_get_contents($url);
        $this->assertNotFalse($content, "Não foi possível acessar $url (verifique o servidor web).");

        // Verificamos se o que recebemos é um JSON válido
        $data = json_decode($content, true);
        $this->assertIsArray($data);
    }
}
