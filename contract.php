<!DOCTYPE html>
<html>
<title>Contract</title>
<link rel="icon" href="image/logo.ico" type="image/x-icon">
<head>
  <style>
    .custom-body {
      font-family: Arial, sans-serif;
      margin-left: 5%;
      margin-right: 5%;
      margin-top: 8%;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    p {
      margin-bottom: 10px;
    }

    .section-heading {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 10px;
    }

    .contract-section {
      margin-bottom: 20px;
    }

    .contract-section p {
      margin-left: 20px;
    }

    .signature-section {
      margin-top: 40px;
    }

    .signature-line {
      display: inline-block;
      width: 250px;
      border-bottom: 1px solid #000;
      margin-bottom: 10px;
    }

    .signature {
      font-weight: bold;
    }
    @media (max-width: 776px) {
            .custom-body {
                margin-top: 100px;
            }
        }
  </style>
</head>

<body class="custom-body">
  <?php
  include "header-home.php";
  ?>
  <h1>Contract of Lease</h1>
  <p class="contract-section">
    <span class="section-heading">On the Stall Constructed by the Municipality</span>
    <br><br>
    KNOW ALL MEN BY THESE PRESENTS:
    <br><br>
    Considering favorably the contest of the hereto attached application for lease of the stall/table space within the Market Compound Wet Section, this CONTRACT OF LEASE is made and executed on this day of <span class="year"></span> at Naujan, Oriental Mindoro, by and between the Municipality of Naujan, represented by its Municipal Mayor, hereinafter called the LESSOR; and <span class="lessee-name"></span> of legal age, married/widow/widower/single, Filipino citizen and resident of Naujan, Oriental Mindoro, hereinafter called the LESSEE.
  </p>
  <p class="contract-section">
    WITNESSETH:
    <br><br>
    That the LESSOR hereby lets the leases unto the LESSEE stall/table No. <span class="stall-no"></span> in the Naujan Market Compound Wet Section for commercial and business purposes.
    <br><br>
    To have hold the same for a period of one (1) year, which can be extended or renewed upon agreement of both the LESSOR and the LESSEE at the end of each term; Provided that such extension or renewal shall not be for more than one (1) year.
    <br>
    <ul>
      <li>The Lessee has to pay P2,000 (Two Thousand Pesos) as advance rental payment.</li>
      <li>To pay the monthly rental fee in the amount of P225.00 (Two Hundred Twenty Five Pesos);</li>
    </ul>
    The said monthly rental shall be paid on or before the end of each month to the Office of the Municipal Treasure.
    <br><br>
    If the LESSEE fails to pay the monthly rental fee within the prescribed period, he/she shall be subjected to pay a surcharge of Twenty Five (25%) percent of the total rental due. Failure to pay the rental fee for three (3) consecutive months shall cause the automatic cancellation of the contract of lease of the stall without produce of suing the LESSEE for the unpaid rents at the expense of the LESSEE. The stall shall also be declared vacant and subject to adjudication. Provided however, that the LESSOR may, while the default shall continue and notwithstanding any waiver of any prior Breach of Condition without notice or demand, enter and remove the LESSEE from the premises, dispose the LESSEE'S goods and effects in accordance with the existing ordinance and regulation relative to the matter, until the process satisfy the amount of the LESSEE'S unpaid rents.
    <br><br>
    <ul>
      <li>Not to make any unlawful, improper, or offensive use of the premises, nor use the same other than as herein specified.</li>
      <li>Not to enter into business partnership with any party acquiring the right to lease.</li>
      <li>Not to assign this lease or to sublease the whole or any part of the premises for any purpose whatsoever.</li>
      <li>To notify the LESSOR within thirty (30) days of any intentions to discontinue business and declare vacancy of stall before the expiration of the lease.</li>
      <li>At the end of the said term, to deliver peacefully to the LESSOR the leased premises, vacant and unencumbered.</li>
      <li>That the conditions enumerated in the accompanying application for lease shall form part of this Contract.</li>
    </ul>
  </p>
  <p class="contract-section">
    The LESSOR hereby covenants with the LESSEE follows;
    <br><br>
    The LESSEE shall peaceably hold and enjoy the leased premises during all time of this Contract of Lease.
  </p>
  <div class="signature-section">
    <p>
      IN WITNESS WHEREOF, the parties hereto have hereunto signed their names at the place above written on this day of <span class="day"></span>, <span class="year"></span>.
    </p>
    <p>
      Municipality of Naujan<br>
      (Lessor)
    </p>
    <div class="signature-line"></div>
    <p class="signature">   <?php
            include "config/config.php";
                            $sql = "SELECT * FROM resources Where id=2";
                            $result = mysqli_query($conn, $sql);
                            ($row = mysqli_fetch_assoc($result));
                            echo $row['content']; 
                           ?></p>
    <p>
      (LESSEE)
    </p>
    <div class="signature-line"></div>
    <p class="signature">LESSEE NAME</p>
    <p>
      SIGNED IN THE PRESENCE OF:
    </p>
    <p>
      JAY MARK Y. BACAY<br>
      LHOTA L. MASILANG
    </p>
  </div>

  <script>
    // Update current year dynamically
    const yearElements = document.getElementsByClassName('year');
    for (let i = 0; i < yearElements.length; i++) {
      yearElements[i].textContent = new Date().getFullYear();
    }

    // Update current day dynamically
    const dayElement = document.getElementsByClassName('day')[0];
    const currentDate = new Date();
    const day = currentDate.getDate();
    dayElement.textContent = day < 10 ? '0' + day : day;

    // Update lessee name dynamically
    const lesseeNameElement = document.getElementsByClassName('lessee-name')[0];
    lesseeNameElement.textContent = 'LESSEE NAME';

    // Update stall number dynamically
    const stallNoElement = document.getElementsByClassName('stall-no')[0];
    stallNoElement.textContent = 'STALL NO';
  </script>
</body>

</html>
