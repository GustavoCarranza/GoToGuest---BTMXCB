<?php
FPDF();

class PDF extends FPDF
{
    protected $widths;
    protected $aligns;

    function Header()
    {
        // Agregar marca de agua en el encabezado de cada página
        $this->SetFont('Arial', 'B', 45);
        $this->SetTextColor(245, 245, 245); // Color gris claro
        $this->SetFillColor(235, 235, 235); // Blanco en este caso
        $this->Text(10, 100, "BANYAN TREE CABO MARQUES");
    }

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 6 * $nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Set the fill color for the cell
            $this->SetFillColor(58, 77, 57); // Color gris claro
            $this->SetTextColor(255, 255, 255); // White text color
            // Draw the background of the cell
            $this->Rect($x, $y, $w, $h, 'FD');
            // Print the text
            $this->MultiCell($w, 6, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function RowCeldas($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 3 * $nb;

        // Issue a page break first if needed
        $this->CheckPageBreak($h);

        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            // Check if the current cell corresponds to the "Salida" column
            if ($i == 4) { // Assuming "Salida" column is the 5th column (0-indexed)
                $fecha_actual = date('Y-m-d H:i:s');
                $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-6 hours', strtotime($fecha_actual)));

                if (date('Y-m-d', strtotime($data[$i])) == date('Y-m-d', strtotime($fecha_actual_ajustada))) {
                    $this->SetFillColor(215, 215, 215); // Light gray background for today's "Salida" column
                    $this->SetTextColor(0, 0, 0); // Black text color
                    $this->Rect($x, $y, $w, $h, 'F'); // Fill the cell with the background color
                    $this->SetDrawColor(0); // Black border for Estado column
                    $this->Rect($x, $y, $w, $h);
                } else {
                    $this->Rect($x, $y, $w, $h);
                    $this->SetTextColor(0); // Default text color
                }
            } elseif ($i == 5) { // Assuming "Estado" column is the 6th column (0-indexed)
                if ($data[$i] == 'Open') {
                    $this->SetFillColor(20, 118, 0); // Green
                    $this->SetTextColor(255, 255, 255); // White
                } elseif ($data[$i] == 'Closed') {
                    $this->SetFillColor(103, 0, 0); // Red
                    $this->SetTextColor(255, 255, 255); // White
                } else {
                    $this->SetFillColor(120, 120, 120); // Gray
                    $this->SetTextColor(255, 255, 255); // White
                }

                $this->Rect($x, $y, $w, $h, 'F');
                $this->SetDrawColor(0); // Black
                $this->Rect($x, $y, $w, $h); // Draw the border for Estado column
            } elseif ($i == 6) { // Column "Level"
                switch ($data[$i]) {
                    case 'Low':
                        $this->SetFillColor(38, 157, 0);
                        $this->SetTextColor(255, 255, 255);
                        break;
                    case 'Medium':
                        $this->SetFillColor(185, 183, 0);
                        $this->SetTextColor(255, 255, 255);
                        break;
                    case 'High':
                        $this->SetFillColor(136, 0, 0);
                        $this->SetTextColor(255, 255, 255);
                        break;
                    case 'In stay':
                        $this->SetFillColor(234, 107, 0);
                        $this->SetTextColor(255, 255, 255);
                        break;
                    case 'Informative':
                        $this->SetFillColor(0, 172, 203);
                        $this->SetTextColor(255, 255, 255);
                        break;
                    case 'Wow moment':
                        $this->SetFillColor(55, 0, 200);
                        $this->SetTextColor(255, 255, 255);
                        break;
                }

                $this->Rect($x, $y, $w, $h, 'F');
                $this->SetDrawColor(0); // Black
                $this->Rect($x, $y, $w, $h); // Draw the border for Estado column
            } else {
                $this->Rect($x, $y, $w, $h);
                $this->SetTextColor(0); // Default text color
            }

            $this->MultiCell($w, 3, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            // Optionally reset the font or other settings if needed
            $this->SetFont('Arial', 'B', 5); // Restore default font if needed
        }
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if (!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string) $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function CellHeader($w, $h, $txt, $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '')
    {
        $currentFont = $this->FontSizePt; // Almacenar el tamaño de fuente actual
        $this->SetFont('Arial', '', 20);
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        $this->SetFontSize($currentFont); // Restaurar el tamaño de fuente original después de usarlo
    }

    function Footer()
    {
        // Adjust the current date and time by subtracting 6 hours
        $fecha_actual_ajustada = date('d/m/Y g:ia', strtotime('-6 hours'));

        $this->SetY(-10);
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(200);
        $this->Write(8, utf8_decode('Generation date: ') . $fecha_actual_ajustada);
        $this->Ln();

        $this->SetY(-10);
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(10);
        $this->Write(8, utf8_decode('Go To Guest' . ' ' . date('Y') . '© Banyan Tree Cabo Marques'));
        $this->Ln();
    }

}
