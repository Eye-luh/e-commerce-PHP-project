<?php
// 1. KONEKSYON SA DATABASE
include 'connection.php';

// 2. SQL QUERY: Gi-join ang tbl_products ug tbl_categories
// Atong gi-join para makuha ang "Category Name" imbes nga ID ra ang makita
$sql = "SELECT p.*, c.categoryName 
        FROM tbl_products p 
        LEFT JOIN tbl_categories c ON p.category_id = c.category_id 
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
?>

<div class="w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-5 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <i class="fas fa-tasks text-white text-xl"></i> 
                <div>
                    <h2 class="text-white font-bold uppercase tracking-widest text-sm">Product Inventory</h2>
                    <p class="text-[10px] text-purple-100 uppercase tracking-wider">Monitor and manage your stock levels</p>
                </div>
            </div>

            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" id="productSearch" onkeyup="searchTable()" 
                       placeholder="Search name or category..." 
                       class="w-full pl-10 pr-4 py-2 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 text-xs outline-none focus:bg-white focus:text-gray-800 transition-all">
            </div>

            <a href="?content=add_product" class="bg-white text-purple-600 px-4 py-2 rounded-xl hover:bg-purple-50 transition-all text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Add New Product
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto" id="productTable">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr class="text-[10px] font-semibold mb-1 text-gray-600 uppercase tracking-[0.2em]">
                        <th class="py-4 px-6 text-left">Image</th>
                        <th class="py-4 px-6 text-left">Product Details</th>
                        <th class="py-4 px-6 text-left">Category</th>
                        <th class="py-4 px-6 text-center">Price</th>
                        <th class="py-4 px-6 text-center">Stock</th>
                        <th class="py-4 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="product-row hover:bg-purple-50/30 transition-all">
                        <td class="py-4 px-6">
                            <div class="w-12 h-12 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 p-1">
                                <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain" alt="Product">
                            </div>
                        </td>
                        
                        <td class="py-4 px-6">
                            <span class="text-sm font-bold text-slate-700 block"><?php echo htmlspecialchars($row['product_name']); ?></span>
                            <span class="text-[10px] text-gray-400 font-medium">ID: #<?php echo $row['product_id']; ?></span>
                        </td>

                        <td class="py-4 px-6">
                            <span class="bg-purple-50 text-purple-600 py-1 px-3 rounded-lg text-[10px] font-bold uppercase tracking-wider border border-purple-100">
                                <?php echo htmlspecialchars($row['categoryName']); ?>
                            </span>
                        </td>

                        <td class="py-4 px-6 text-center font-bold text-slate-700 text-sm">
                            ₱<?php echo number_format($row['price'], 2); ?>
                        </td>

                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-lg text-xs font-bold <?php echo ($row['quantity'] <= 5) ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-green-600 border border-green-100'; ?>">
                                <?php echo $row['quantity']; ?>
                            </span>
                        </td>

                        <td class="py-4 px-6">
                            <div class="flex justify-center gap-2">
                                <a href="dashboard.php?content=edit_product&id=<?php echo $row['product_id']; ?>" 
                                   class="h-8 w-8 flex items-center justify-center text-blue-500 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all shadow-sm">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>

                                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this product?')"
                                   class="h-8 w-8 flex items-center justify-center text-red-500 bg-red-50 rounded-lg hover:bg-red-100 transition-all shadow-sm">
                                    <i class="fas fa-trash text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function searchTable() {
    let input = document.getElementById("productSearch").value.toLowerCase();
    let rows = document.getElementsByClassName("product-row");

    for (let i = 0; i < rows.length; i++) {
        let text = rows[i].innerText.toLowerCase();
        // Kon naay match sa gi-type, ipakita ang row. Kon wala, itago.
        rows[i].style.display = text.includes(input) ? "" : "none";
    }
}
</script>