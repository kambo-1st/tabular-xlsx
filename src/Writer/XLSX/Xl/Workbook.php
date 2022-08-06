<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\Xl;

use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;

final class Workbook extends AbstractPart
{
    protected function getDefaultPath(): string
    {
        return 'xl';
    }

    protected function getDefaultFilename(): string
    {
        return 'workbook.xml';
    }
    public function addData(mixed $data)
    {
    }

    public function generate()
    {
        $xw = $this->getXMLWriter();

        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('workbook');
        $xw->startAttribute('xmlns');
        $xw->text('http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:r');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/relationships');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:mc');
        $xw->text('http://schemas.openxmlformats.org/markup-compatibility/2006');
        $xw->endAttribute();

        $xw->startAttribute('mc:Ignorable');
        $xw->text('x15 xr xr6 xr10 xr2');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:x15');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2010/11/main');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2014/revision');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr6');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2016/revision6');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr10');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2016/revision10');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr2');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2015/revision2');
        $xw->endAttribute();

        $xw->startElement('fileVersion');
        $xw->startAttribute('appName');
        $xw->text('xl');
        $xw->endAttribute();
        $xw->startAttribute('lastEdited');
        $xw->text('7');
        $xw->endAttribute();
        $xw->startAttribute('lowestEdited');
        $xw->text('7');
        $xw->endAttribute();
        $xw->startAttribute('rupBuild');
        $xw->text('25330');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('workbookPr');
        $xw->startAttribute('defaultThemeVersion');
        $xw->text('166925');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('mc:AlternateContent');

        $xw->startAttribute('xmlns:mc');
        $xw->text('http://schemas.openxmlformats.org/markup-compatibility/2006');
        $xw->endAttribute();

        $xw->startElement('mc:Choice');
        $xw->startAttribute('Requires');
        $xw->text('x15');
        $xw->endAttribute();
        $xw->startElement('x15ac:absPath');

        $xw->startAttribute('url');
        $xw->text('C:');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:x15ac');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2010/11/ac');
        $xw->endAttribute();

        $xw->endElement();
        $xw->endElement();
        $xw->endElement();

        $xw->startElement('xr:revisionPtr');
        $xw->startAttribute('xr6:coauthVersionLast');
        $xw->text('47');
        $xw->endAttribute();
        $xw->startAttribute('xr6:coauthVersionMax');
        $xw->text('47');
        $xw->endAttribute();
        $xw->startAttribute('xr10:uidLastSave');
        $xw->text('{00000000-0000-0000-0000-000000000000}');
        $xw->endAttribute();
        $xw->startAttribute('revIDLastSave');
        $xw->text('0');
        $xw->endAttribute();
        $xw->startAttribute('documentId');
        $xw->text('13_ncr:1_{5D172A4E-7307-489C-9A02-05B0B4472C6C}');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('bookViews');
        $xw->startElement('workbookView');
        $xw->startAttribute('xr2:uid');
        $xw->text('{76AA7E61-B29C-4BF8-9EDE-F3BF3D35D8E4}');
        $xw->endAttribute();
        $xw->startAttribute('xWindow');
        $xw->text('-120');
        $xw->endAttribute();
        $xw->startAttribute('yWindow');
        $xw->text('-120');
        $xw->endAttribute();
        $xw->startAttribute('windowWidth');
        $xw->text('29040');
        $xw->endAttribute();
        $xw->startAttribute('windowHeight');
        $xw->text('15720');
        $xw->endAttribute();

        $xw->endElement();
        $xw->endElement();

        $xw->startElement('sheets');

        $xw->startElement('sheet');
        $xw->startAttribute('name');
        $xw->text('Sheet1');
        $xw->endAttribute();
        $xw->startAttribute('sheetId');
        $xw->text('1');
        $xw->endAttribute();
        $xw->startAttribute('r:id');
        $xw->text('rId1');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();

        $xw->startElement('calcPr');
        $xw->startAttribute('calcId');
        $xw->text('191029');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('extLst');

        $xw->startElement('ext');
        $xw->startAttribute('uri');
        $xw->text('{140A7094-0E35-4892-8432-C4D2E57EDEB5}');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:x15');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2010/11/main');
        $xw->endAttribute();

        $xw->startElement('x15:workbookPr');
        $xw->startAttribute('chartTrackingRefBase');
        $xw->text('1');
        $xw->endAttribute();

        $xw->endElement();

        $xw->endElement();

        $xw->startElement('ext');
        $xw->startAttribute('uri');
        $xw->text('{B58B0392-4F1F-4190-BB64-5DF3571DCE5F}');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:xcalcf');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2018/calcfeatures');
        $xw->endAttribute();

        $xw->startElement('xcalcf:calcFeatures');
        $xw->startElement('xcalcf:feature');
        $xw->startAttribute('name');
        $xw->text('microsoft.com:RD');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('xcalcf:feature');
        $xw->startAttribute('name');
        $xw->text('microsoft.com:Single');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('xcalcf:feature');
        $xw->startAttribute('name');
        $xw->text('microsoft.com:FV');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('xcalcf:feature');
        $xw->startAttribute('name');
        $xw->text('microsoft.com:CNMTM');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('xcalcf:feature');
        $xw->startAttribute('name');
        $xw->text('microsoft.com:LET_WF');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('xcalcf:feature');
        $xw->startAttribute('name');
        $xw->text('microsoft.com:LAMBDA_WF');
        $xw->endAttribute();

        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        return $this->finalizeXMLWriter($xw);
    }
}
