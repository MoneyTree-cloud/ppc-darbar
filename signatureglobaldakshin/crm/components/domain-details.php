

<div class="overlay" id="overlay" style="display: none;">
          <div class="form-container" style="max-width: 600px; width: 100%; flex-direction: column;">
            <h2>Add Domain</h2>
            <div class="close" onclick="closeForm()"><ion-icon name="close-outline"></ion-icon></div>
            <!-- <h3 id="domainHeading">Lead from Domain.in</h3> -->
            <form action="php/save_domain.php" method="post" class="lead_form">
              
              <input type="hidden" name="id" id="domainId" required />
              
              <div class="form-group">
                <input type="text" name="domain_name" id="domain_name" placeholder="" required />
                <label for="domain_name">Domain Name</label>
              </div>
              <div class="form-group">
                <input type="text" name="Project_name" id="project_name" placeholder="" required />
                <label for="project_name">Project Name</label>
              </div>
              <div class="form-group">
                <input type="number" name="index_no" id="index_no" placeholder="" required/>
                <label for="index_no">Index No.</label>
              </div>
              <div class="col" style="max-width: 400px; flex-wrap: wrap;">
                <div class="form-group" style="width: 100%; max-width: 180px;">
                  <input type="text" name="date_time" id="datetimeInput" required disabled/>
                  <label for="datetimeInput">Added on</label>
                </div>
                  <div class="form-group" style="width: 100%; max-width: 180px;">
                  <input type="text" name="updated_on" id="lastUpdatedInput" disabled/>
                  <label for="lastUpdatedInput">Last Updated</label>
                </div>
              </div>
              <div class="form-group">
                <select class="filter-select" name="status" id="statusInput">
                  <option value="active">Acive</option>
                  <option value="inactive">Inactive</option>
                </select>
                <ion-icon name="chevron-down-outline"></ion-icon>
              </div>

              <p class="domain-index">last domain index is <span id="domainIndex"><?php echo $last_index; ?></span></p>
              <div class="button">            
                <button class="btn">Save</button>
            </div>
            </form>
          </div>
        </div>
