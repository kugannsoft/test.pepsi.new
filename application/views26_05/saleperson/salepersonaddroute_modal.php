<!-- Modal HTML structure -->

            <form action="<?php echo base_url('admin/sales/save_route'); ?>" method="POST">
                <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $employee_id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-power-off myclose"></i>
                    </button>
                    <h4>Route Management for Employee ID: <?php echo $employee_id; ?></h4> 
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="route">Select Route:</label>
                        <select name="route_id" id="route" class="form-control" required>
                            <option value="">Select a route</option>
                            <?php foreach ($routes as $route): ?>
                                <option value="<?php echo $route->id; ?>"><?php echo $route->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Route</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

                           
                </form>
                <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <!-- <th>Table ID</th> -->
                                <th>Route Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($saved_routes)): ?>
                                <?php foreach ($saved_routes as $index => $saved_route): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <!-- <td><?php echo $saved_route->id; ?></td> -->
                                        <td><?php echo $saved_route->name; ?></td>
                                        <td>
                                            <form action="<?php echo base_url('admin/sales/delete_route/' . $saved_route->id); ?>" method="POST" style="display: inline;">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this route?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No saved routes found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                         
           




