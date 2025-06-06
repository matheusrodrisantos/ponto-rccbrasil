<?php

namespace App\Tests\Entity\ValueObject;
use App\Entity\ValueObject\BatidaPonto;
use App\Exception\RegraDeNegocioFuncionarioException;
use App\Exception\RegraDeNegocioRegistroPontoException;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class BatidaPontoTest extends TestCase
{
    private DateTimeZone $timezone;

    protected function setUp(): void
    {
        $this->timezone = new DateTimeZone('America/Sao_Paulo');
    }

    public function testDeveRegistrarEntrada(): void
    {
        $entrada = new DateTimeImmutable('09:00', $this->timezone);
        $batida = new BatidaPonto();
        
        $novaBatida = $batida->registrar($entrada);
        
        $this->assertEquals('09:00:00', $novaBatida->entrada());
        $this->assertNull($novaBatida->saida());
    }

    public function testDeveRegistrarSaida(): void
    {
        $entrada = new DateTimeImmutable('09:00', $this->timezone);
        $saida = new DateTimeImmutable('18:00', $this->timezone);
        $batida = new BatidaPonto($entrada);

        $novaBatida = $batida->registrar($saida);

        $this->assertEquals('09:00:00', $novaBatida->entrada());
        $this->assertEquals('18:00:00', $novaBatida->saida());
    }

    public function testDeveLancarExcecaoQuandoRegistrarSaidaAntesDeEntrada(): void
    {
        $entrada = new DateTimeImmutable('09:00', $this->timezone);
        $saidaInvalida = new DateTimeImmutable('08:00', $this->timezone);
        $batida = new BatidaPonto($entrada);

        $this->expectException(RegraDeNegocioRegistroPontoException::class);
        $batida->registrar($saidaInvalida);
    }

    public function testDeveLancarExcecaoQuandoPontoJaCompleto(): void
    {
        $entrada = new DateTimeImmutable('09:00', $this->timezone);
        $saida = new DateTimeImmutable('18:00', $this->timezone);
        $batida = new BatidaPonto($entrada, $saida);

        $this->expectException(RegraDeNegocioFuncionarioException::class);
        $batida->registrar(new DateTimeImmutable());
    }

    public function testDeveVerificarSeEstaAberto(): void
    {
        $entrada = new DateTimeImmutable('09:00', $this->timezone);
        $batida = new BatidaPonto($entrada);

        $this->assertTrue($batida->estavaAberto());
    }

    public function testDeveVerificarSeEstaCompleto(): void
    {
        $entrada = new DateTimeImmutable('09:00', $this->timezone);
        $saida = new DateTimeImmutable('18:00', $this->timezone);
        $batida = new BatidaPonto($entrada, $saida);

        $this->assertTrue($batida->completo());
    }

    public function testDeveCalcularSaldo(): void
    {
        $entrada = new DateTimeImmutable('09:00:00', $this->timezone);
        $saida = new DateTimeImmutable('09:00:10', $this->timezone);
        $batida = new BatidaPonto($entrada, $saida);

        $saldo = $batida->calcularSaldo();
    
        $this->assertEquals(10, $saldo->s);
    }
}