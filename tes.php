<?php
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $harga = $row['harga'];
                
                    // Pastikan $harga memiliki nilai sebelum digunakan
                    if ($harga !== null) {
                        $total = ($harga * $kuantitas) - $diskon;
                
                        $insertQuery = "INSERT INTO pesanan (tanggal, namapelanggan, namalayanan, harga, kuantitas, diskon, total, pembayaran, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmtInsert = $conn->prepare($insertQuery);
                        $stmtInsert->bind_param("sssiidiis", $tanggal, $namaPelanggan, $namaLayanan, $harga, $kuantitas, $diskon, $total, $pembayaran, $username);
                        
                        if ($stmtInsert->execute()) {
                            echo "Data inserted successfully";
                        } else {
                            echo "Error inserting data: " . $stmtInsert->error;
                        }
                    } else {
                        echo "Harga tidak valid";
                    }
                } else {
                    echo "Service not found";
                }                
                ?>