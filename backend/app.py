from flask import Flask, request, jsonify
from flask_cors import CORS
from scipy.optimize import minimize

app = Flask(__name__)
CORS(app)

@app.route('/calculate_course_fee', methods=['POST'])
def calculate_course_fee():
  data = request.json  # Received input data from the frontend

  # Extract parameters from the data
  M1ACOC = data['M1ACOC']
  M1CPMP = data['M1CPMP']
  R5 = data['R5']
  target_course_fee = data['target_course_fee']
  initial_guess = data['M1ANUEBEP']

  # Define the function for optimization
  def objective_function(parameters):
      M1_l = parameters[0]

      # Calculate course fee using the provided formula
      course_fee = (((M1ACOC + (M1_l * R5)) / M1_l) * (100 + M1CPMP) / 100)
      return abs(course_fee - target_course_fee)

  # Perform optimization
  result = minimize(objective_function, [initial_guess], method='Nelder-Mead')

  if result.success:
    # Calculate achieved course fee if optimization was successful
    achieved_fee = (((M1ACOC + (result.x[0] * R5)) / result.x[0]) * (100 + M1CPMP) / 100)
    return jsonify({
      'result': result.x[0],  # The optimized parameter value
      'achieved_fee': achieved_fee,
      'success': True,
      'reload_page': True,
    })
  else:
    return jsonify({
      'message': 'Optimization did not converge',
      'success': False
    })

@app.route('/calculate_certificate_fee', methods=['POST'])
def calculate_certificate_fee():
  data = request.json  # Received input data from the frontend

  # Extract parameters from the data
  CCE = data['CCE']
  M2CEESC = data['M2CEESC']
  M2FCOC = data['M2FCOC']
  M2HPMP = data['M2HPMP']
  target_certificate_fee = data['target_certificate_fee']
  initial_guess = data['M2ANUEBEP']

  # Define the function for optimization
  def objective_function(parameters):
    M2_cl = parameters[0]

    # Calculate certificate fee using the provided formula
    certificate_fee = (((M2FCOC + (((1 / (M2CEESC / 100)) * M2_cl) * CCE)) / ((1 / (M2CEESC / 100)) * M2_cl)) * ((100 + M2HPMP) / 100))

    return abs(certificate_fee - target_certificate_fee)

  # Perform optimization
  result = minimize(objective_function, [initial_guess], method='Nelder-Mead')

  if result.success:
    # Calculate achieved certificate fee if optimization was successful
    achieved_fee = (((M2FCOC + (((1 / (M2CEESC / 100)) * result.x[0]) * CCE)) / ((1 / (M2CEESC / 100)) * result.x[0])) * ((100 + M2HPMP) / 100))

    return jsonify({
        'result': result.x[0],  # The optimized parameter value
        'achieved_fee': achieved_fee,
        'success': True,
        'reload_page': True,
    })
  else:
    return jsonify({
      'message': 'Optimization did not converge',
      'success': False
    })

if __name__ == '__main__':
  app.run(debug=True)
