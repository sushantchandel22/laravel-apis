<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <div id="products-container"></div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('http://127.0.0.1:8000/api/view-products')
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        let productsHtml = '';
                        data.product.data.forEach(product => {
                            productsHtml += `<h2>${product.title}</h2>`;
                            productsHtml += `<h4>${product.description}</h4>`;
                            productsHtml +=
                                `<button data-product-id="${product.id}" class="add-to-cart">Add To Cart</button>`;
                            if (product.productimages.length > 0) {
                                let firstImage = product.productimages[0];
                                productsHtml +=
                                    `<img style="width:200px" src="${firstImage.url}" alt="${product.title}">`;
                            }
                        });
                        document.getElementById('products-container').innerHTML = productsHtml;
                        document.addEventListener('click', function(event) {
                            if (event.target.classList.contains('add-to-cart')) {
                                let product_id = event.target.getAttribute('data-product-id');
                                let quantity = 1;
                                let tempUserId = 59;
                                localStorage.setItem('tempUserId', tempUserId);
                                let requestBody = {
                                    userId: tempUserId,
                                    products: [{
                                        product_id,
                                        quantity
                                    }]
                                };
                                fetch('http://127.0.0.1:8000/api/cartdata', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify(requestBody)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status) {
                                            console.log('Added to cart successfully!');
                                        } else {
                                            console.log(`Error: ${data.message}`);
                                        }
                                    })
                                    .catch(error => {
                                        console.log(`Error: ${error}`);
                                    });
                            }
                        });
                    } else {
                        alert(`Error: ${data.message}`);
                    }
                })
                .catch(error => {
                    console.log(`Error: ${error}`);
                });
        });
    </script>
</body>

</html>
