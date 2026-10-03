<?php  
// Incluir la conexión a la base de datos  
require 'includes/db.php';  

// Obtener todas las publicaciones  
$publicaciones = $pdo->query("SELECT * FROM publicaciones ORDER BY fecha_creacion DESC")->fetchAll();  
?>  

<?php include 'includes/header.php'; ?>  

<!-- Estilos personalizados para el carrusel y las tarjetas -->  
<style>  
    .carousel-inner img {  
        height: 300px;  
        object-fit: cover;  
    }  
    .carousel-indicators button {  
        background-color: #333;  
        border: none;  
        width: 12px;  
        height: 12px;  
        border-radius: 50%;  
        margin: 0 4px;  
    }  
    .carousel-indicators .active {  
        background-color: #007bff;  
    }  
    .card {  
        margin-bottom: 30px;  
    }  
</style>  

<div class="container mt-5">  
    <h1 class="text-center mb-4">Catálogo de Páginas Web</h1>  

    <!-- Mostrar mensaje de éxito -->  
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>  
        <div class="alert alert-success text-center">  
            Publicación agregada correctamente.  
        </div>  
    <?php endif; ?>  

    <?php if (empty($publicaciones)): ?>  
        <p class="text-center">No hay publicaciones disponibles.</p>  
    <?php else: ?>  
        <div class="row">  
            <?php foreach ($publicaciones as $publicacion): ?>  
                <div class="col-md-6 mb-4">  
                    <div class="card shadow-sm">  
                        <div class="card-body">  
                            <h2 class="card-title"><?php echo htmlspecialchars($publicacion['titulo']); ?></h2>  
                            <p class="card-text"><?php echo htmlspecialchars($publicacion['descripcion']); ?></p>  

                            <?php  
                            // Obtener las imágenes de la publicación  
                            $stmt = $pdo->prepare("SELECT ruta_imagen FROM imagenes WHERE publicacion_id = ?");  
                            $stmt->execute([$publicacion['id']]);  
                            $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);  
                            ?>  

                            <?php if (!empty($imagenes)): ?>  
                                <!-- Carrusel integrado con Bootstrap -->  
                                <div id="carousel-<?php echo $publicacion['id']; ?>" class="carousel slide" data-bs-ride="carousel">  
                                    <?php if (count($imagenes) > 1): ?>  
                                        <div class="carousel-indicators">  
                                            <?php foreach ($imagenes as $key => $ruta_imagen): ?>  
                                                <button type="button" data-bs-target="#carousel-<?php echo $publicacion['id']; ?>"   
                                                    data-bs-slide-to="<?php echo $key; ?>"   
                                                    class="<?php echo $key === 0 ? 'active' : ''; ?>"   
                                                    aria-current="<?php echo $key === 0 ? 'true' : 'false'; ?>"   
                                                    aria-label="Slide <?php echo $key + 1; ?>"></button>  
                                            <?php endforeach; ?>  
                                        </div>  
                                    <?php endif; ?>  

                                    <div class="carousel-inner">  
                                        <?php foreach ($imagenes as $key => $ruta_imagen): ?>  
                                            <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>">  
                                                <img src="admin/<?php echo htmlspecialchars($ruta_imagen); ?>" class="d-block w-100" alt="Imagen de la publicación">  
                                            </div>  
                                        <?php endforeach; ?>  
                                    </div>  

                                    <?php if (count($imagenes) > 1): ?>  
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $publicacion['id']; ?>" data-bs-slide="prev">  
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>  
                                            <span class="visually-hidden">Anterior</span>  
                                        </button>  
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $publicacion['id']; ?>" data-bs-slide="next">  
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>  
                                            <span class="visually-hidden">Siguiente</span>  
                                        </button>  
                                    <?php endif; ?>  
                                </div>  
                            <?php else: ?>  
                                <p>No hay imágenes para esta publicación.</p>  
                            <?php endif; ?>  
                        </div>  
                    </div>  
                </div>  
            <?php endforeach; ?>  
        </div>  
    <?php endif; ?>  
</div>  

<?php include 'includes/footer.php'; ?>