                if (response.length > 0) {
                    let html = '<ul class="list-group">';
                    response.forEach(obat => {
                        html += `<li class="list-group-item">${obat.name}</li>`;
                    });
                    html += '</ul>';
                    $('#obat-list').html(html);
                } else {
                    $('#obat-list').html('<p class="text-muted">Tidak ada obat yang terdaftar untuk penyakit ini.</p>');
                }
