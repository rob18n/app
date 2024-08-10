<template>
    <div id="content" class="col-12 col-md-8">
        <div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>ab.cde.fghi</h5>
                    <p>Lorem ipsum</p>
                </div>
                <div>
                    <div class="btn-group">
                        <div class="btn btn-secondary">
                            <BsPencilFill />
                        </div>
                        <div class="btn btn-danger">
                            <BsTrashFill />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">de_DE</label>
                <textarea class="form-control" id="description" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">en_US</label>
                <textarea class="form-control" id="description" rows="3"></textarea>
            </div>
        </div>
    </div>
</template>
<script setup>
</script>