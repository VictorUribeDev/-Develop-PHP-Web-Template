<?php  
// Incluir la conexión a la base de datos y autenticación  
require '../includes/db.php';  
require '../includes/auth.php';  
requireAuth(); // Redirige si no está autenticado  

// Inicializar variables  
$error = '';  
$success_message = '';  
$publicacion_id = null;  

// Procesar el formulario de agregar publicación  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    try {  
        $titulo = $_POST['titulo'];  
        $descripcion = $_POST['descripcion'];  

        // Validar campos vacíos  
        if (empty($titulo) || empty($descripcion)) {  
            throw new Exception("Todos los campos son obligatorios.");  
        }  

        // Insertar la publicación en la base de datos  
        $stmt = $pdo->prepare("INSERT INTO publicaciones (titulo, descripcion) VALUES (?, ?)");  
        if (!$stmt->execute([$titulo, $descripcion])) {  
            throw new Exception("Error al insertar la publicación.");  
        }  

        $publicacion_id = $pdo->lastInsertId();  

        // Procesar imágenes  
        if (!empty($_FILES['imagenes']['name'][0])) {  
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];  
            
            foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {  
                $file_type = $_FILES['imagenes']['type'][$key];  
                
                // Validar tipo de archivo  
                if (!in_array($file_type, $allowed_types)) {  
                    throw new Exception("Tipo de archivo no permitido: " . $_FILES['imagenes']['name'][$key]);  
                }  

                // Generar nombre único y subir archivo  
                $file_name = uniqid() . '_' . basename($_FILES['imagenes']['name'][$key]);  
                $ruta = 'uploads/' . $file_name;  

                if (!move_uploaded_file($tmp_name, $ruta)) {  
                    throw new Exception("Error al subir la imagen: " . $_FILES['imagenes']['name'][$key]);  
                }  

                // Insertar la imagen en la base de datos  
                $stmt_img = $pdo->prepare("INSERT INTO imagenes (publicacion_id, ruta_imagen) VALUES (?, ?)");  
                if (!$stmt_img->execute([$publicacion_id, $ruta])) {  
                    throw new Exception("Error al guardar la imagen en la base de datos.");  
                }  
            }  
        }  

        // Mensaje de éxito  
        $success_message = "Publicación agregada con éxito.";  
        
    } catch (Exception $e) {  
        $error = $e->getMessage();  
    }  
}  

// Procesar eliminación de publicación  
if (isset($_GET['eliminar']) && $_GET['eliminar'] == 'true' && isset($_GET['publicacion_id'])) {  
    $publicacion_id = $_GET['publicacion_id'];  
    try {  
        // Eliminar imágenes del sistema de archivos  
        $stmt = $pdo->prepare("SELECT ruta_imagen FROM imagenes WHERE publicacion_id = ?");  
        $stmt->execute([$publicacion_id]);  
        $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);  

        foreach ($imagenes as $imagen) {  
            if (file_exists($imagen)) {  
                unlink($imagen);  
            }  
        }  

        // Eliminar la publicación de la base de datos  
        $stmt_publicacion = $pdo->prepare("DELETE FROM publicaciones WHERE id = ?");  
        $stmt_publicacion->execute([$publicacion_id]);  

        // Eliminar imágenes de la base de datos  
        $stmt_eliminar_imagenes = $pdo->prepare("DELETE FROM imagenes WHERE publicacion_id = ?");  
        $stmt_eliminar_imagenes->execute([$publicacion_id]);  

        // Mensaje de éxito  
        $success_message = "Publicación y sus imágenes eliminadas con éxito.";  
        $publicacion_id = null;  
    } catch (Exception $e) {  
        $error = $e->getMessage();  
    }  
}  

// Obtener todas las publicaciones  
$publicaciones = $pdo->query("SELECT p.id, p.titulo, p.descripcion FROM publicaciones p ORDER BY p.fecha_creacion DESC")->fetchAll(PDO::FETCH_ASSOC);  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Agregar Publicación</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
</head>  
<body>  
    <div class="container mt-5">  
        <h1 class="text-center">Agregar Nueva Publicación</h1>  

        <!-- Mostrar mensajes de error -->  
        <?php if (!empty($error)): ?>  
            <div class="alert alert-danger">  
                <?php echo htmlspecialchars($error); ?>  
            </div>  
        <?php endif; ?>  

        <!-- Mostrar mensaje de éxito -->  
        <?php if (!empty($success_message)): ?>  
            <div class="alert alert-success">  
                <?php echo htmlspecialchars($success_message); ?>  
            </div>  
        <?php endif; ?>  

        <form method="POST" enctype="multipart/form-data">  
            <div class="mb-3">  
                <label class="form-label">Título:</label>  
                <input type="text" name="titulo" class="form-control" required>  
            </div>  
            <div class="mb-3">  
                <label class="form-label">Descripción:</label>  
                <textarea name="descripcion" class="form-control" rows="4" required></textarea>  
            </div>  
            <div class="mb-3">  
                <label class="form-label">Imágenes:</label>  
                <input type="file" name="imagenes[]" class="form-control" multiple required>  
            </div>  
            <button type="submit" class="btn btn-primary">Agregar</button>  
        </form>  

        <!-- Mostrar publicaciones en una tabla -->  
        <div class="mt-4">  
            <h3>Publicaciones:</h3>  
            <table class="table">  
                <thead>  
                    <tr>  
                        <th>Título</th>  
                        <th>Descripción</th>  
                        <th>Imágenes</th>  
                        <th>Acciones</th>  
                    </tr>  
                </thead>  
                <tbody>  
                    <?php foreach ($publicaciones as $publicacion): ?>  
                        <tr>  
                            <td><?php echo htmlspecialchars($publicacion['titulo']); ?></td>  
                            <td><?php echo htmlspecialchars($publicacion['descripcion']); ?></td>  
                            <td>  
                                <?php  
                                // Obtener las imágenes de la publicación  
                                $stmt_imagenes = $pdo->prepare("SELECT ruta_imagen FROM imagenes WHERE publicacion_id = ?");  
                                $stmt_imagenes->execute([$publicacion['id']]);  
                                $imagenes = $stmt_imagenes->fetchAll(PDO::FETCH_COLUMN);  
                                
                                if ($imagenes):  
                                    echo '<div class="row">';  
                                    foreach ($imagenes as $imagen): ?>  
                                        <div class="col-4">  
                                            <img src="<?php echo htmlspecialchars($imagen); ?>" class="img-fluid" style="max-height: 100px; object-fit: cover;" alt="Imagen">  
                                        </div>  
                                    <?php endforeach;   
                                    echo '</div>';  
                                else:   
                                    echo "No hay imágenes disponibles.";  
                                endif;   
                                ?>  
                            </td>  
                            <td>  
                                <form method="GET" action="" style="display:inline;">  
                                    <input type="hidden" name="eliminar" value="true">  
                                    <input type="hidden" name="publicacion_id" value="<?php echo $publicacion['id']; ?>">  
                                    <button type="submit" class="btn btn-danger">Eliminar</button>  
                                </form>  
                            </td>  
                        </tr>  
                    <?php endforeach; ?>  
                </tbody>  
            </table>  
        </div>  
    </div>  
</body>  
</html>
